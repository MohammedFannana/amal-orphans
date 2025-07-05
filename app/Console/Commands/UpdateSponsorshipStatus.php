<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Orphan;
use App\Models\Sponsorship;
use Illuminate\Console\Command;
use App\Notifications\SponsorshipEnded;
use App\Notifications\SponsorshipEndingSoon;

class UpdateSponsorshipStatus extends Command
{
    protected $signature = 'sponsorships:update-status';

    protected $description = 'تحديث حالة الكفالات بناءً على انتهاء المدة أو بلوغ اليتيم 18 سنة';

    protected int $daysLeft = 0;

    public function handle()
    {
        $today = Carbon::today(); // تاريخ اليوم بدون وقت

        $sponsorships = Sponsorship::where('status', 'active')->get();

        foreach ($sponsorships as $sponsorship) {
            // حساب تاريخ انتهاء الكفالة مع تصفير الوقت
            $endDate = Carbon::parse($sponsorship->sponsorship_date)
                        ->addMonths($sponsorship->duration)
                        ->startOfDay();

            $this->daysLeft = $today->diffInDays($endDate, false);

            $orphan = $sponsorship->orphan;

            // تحقق من عمر اليتيم، إذا بلغ 18 سنة يتم إنهاء الكفالة وتغيير الحالة
            if ($orphan && $orphan->birth_date) {
                $age = Carbon::parse($orphan->birth_date)->age;
                if ($age >= 18) {
                    $sponsorship->update(['status' => 'finished']);
                    $orphan->update(['role' => 'rejected']);
                    $this->info("⛔ تم إنهاء الكفالة رقم {$sponsorship->id} لأن اليتيم {$orphan->name} بلغ 18 عامًا.");
                    $this->notifyAboutSponsorship($sponsorship, 'ended');
                    continue; // انتقل للكفالة التالية
                }
            }

            // تحقق إذا انتهت الكفالة اليوم
            if ($today->greaterThanOrEqualTo($endDate)) {
                $sponsorship->update(['status' => 'finished']);
                $this->info("✅ الكفالة رقم {$sponsorship->id} أصبحت منتهية.");
                $this->notifyAboutSponsorship($sponsorship, 'finish');
            }


            // إشعارات قبل انتهاء الكفالة بـ 30, 14, أو 3 أيام
            elseif (in_array($this->daysLeft, [30, 14, 3])) {
                $this->info("🔔 الكفالة رقم {$sponsorship->id} ستنتهي بعد {$this->daysLeft} يومًا.");
                $this->notifyAboutSponsorship($sponsorship, 'soon');
            }
        }

        // تحديث حالة الأيتام الذين ليس لديهم كفالة نشطة
        Orphan::with('sponsorships')->each(function ($orphan) {
            $hasActive = $orphan->sponsorships()->where('status', 'active')->exists();
            if (!$hasActive && $orphan->role !== 'waiting') {
                $orphan->update(['role' => 'waiting']);
                $this->info("⏳ تم تحديث حالة اليتيم {$orphan->name} إلى انتظار.");
            }
        });

        $this->info('✅ تمت معالجة جميع الكفالات والأيتام بنجاح.');
    }

    protected function notifyAboutSponsorship(Sponsorship $sponsorship, string $type = 'soon'): void
    {
        $message = match ($type) {
            'ended' => "تم إنهاء الكفالة رقم {$sponsorship->id} لأن اليتيم {$sponsorship->orphan->name} بلغ 18 عامًا .",
            'finish' => "تم إنهاء الكفالة رقم {$sponsorship->id} لأن اليتيم {$sponsorship->orphan->name}  انتهت مدة الكفالة.",
            'soon' => "🔔 الكفالة رقم {$sponsorship->id} لليتيم {$sponsorship->orphan->name} ستنتهي بعد {$this->daysLeft} يومًا.",
        };

        $notification = $type === 'ended' || $type === 'finish'
            ? new SponsorshipEnded($sponsorship, $message)
            : new SponsorshipEndingSoon($sponsorship, $message);


        // إشعار الكافل
        $sponsorship->sponsor?->notify($notification);
        // إشعار الجمعية المرتبطة باليتيم
        $sponsorship->orphan?->association?->notify($notification);

        // إشعار مسؤول النظام (يمكن تعديل ليصل لمدير محدد حسب الحاجة)
        User::first()?->notify($notification);

        // إشعار اليتيم في حالة الانتهاء أو قبل 3 أيام من الانتهاء
        if ($type === 'ended' || $type === 'finish' || $this->daysLeft === 3) {
            $sponsorship->orphan?->notify($notification);
        }
    }
}
