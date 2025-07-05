<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <title>أمل لأبناء الشهداء</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.rtl.min.css" integrity="sha384-q8+l9TmX3RaSz3HKGBmqP2u5MkgeN7HrfOJBLcTgZsQsbrx8WqqxdA5PuwUV9WIx" crossorigin="anonymous">
    <style>

        .announcements-carousel-section {
            background-color: #f9fff9;
        }

        .carousel-inner img {
            max-height: 400px;
            object-fit: cover;
        }

        .custom-arrow .carousel-control-prev-icon,
        .custom-arrow .carousel-control-next-icon {
            background-color: var(--primary-color);
            border-radius: 50%;
        }

        .stats-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s;
        }

        .stats-card:hover {
            transform: scale(1.05);
        }

        .stats-circle {
            width: 130px;
            height: 130px;
            border: 4px solid var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .stats-number {
            font-size: 36px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stats-label {
            margin-top: 15px;
            font-size: 18px;
            font-weight: 600;
            color: #444;
        }



    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg">
        <div class="container" >
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-brand">
                <img src="{{asset('images/logo.png')}}" alt="">
                <img src="{{asset('images/logo2.png')}}" alt="">
            </div>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="gap: 24px">
                    <li class="nav-item">
                        <a class="nav-link" href="#">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">من نحن</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">تواصل معنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#question"> الأسئلة الشائعة </a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    <a class="submit-btn text-decoration-none" href="{{route('login')}}" type="button"> تسجيل الدخول </a>

                    <a class="submit-btn text-decoration-none" href="{{route('front.waiting.orphan')}}" type="button"> اكفل يتيم الآن! </a>
                </div>
            </div>
        </div>
    </nav>




    {{--start about us  --}}
        <section class="mt-5 mb-5">

            <div class="container">
                {{-- section header component --}}
                <x-header title="  النشأة والتعريف " />

                <div class="border border-1 rounded p-3" style="border-top-color:#f0fff4 !important; line-height:2 ; font-size:17px">

                    تأسست جمعية مناصرة فلسطين عام 1423 هـ الموافق 2002 م بترخيص وزارة التنمية الاجتماعية رقم 50/2002 ، وهي جمعية أهلية تطوعية غير هادفة للربح وذلك على أيدي نخبة من الغيورين على القضية الفلسطينية والذين يسعون لأن تبقى فلسطين حاضرة في الأذهان، كما يسعون إلى نشر الوعي بين مختلف فئات المجتمع في البحرين بأهمية هذه القضية وموريتها للأمة  العربية والإسلامية ونصرة فلسطين وشعبها بكافة الوسائل المشروعة.

                </div>
            </div>

        </section>


        <section class="mt-5 mb-5">

            <div class="container">
                {{-- section header component --}}
                <x-header title=" أهداف الجمعية " />

                <div class="border border-1 rounded p-3 " style="border-top-color:#f0fff4 !important ; line-height:2 ; font-size:17px">

                    تقوم جمعية مناصرة فلسطين بالعمل على تحقيق الأهداف التالية:
                    <br>
                    <div class="ps-2">
                        دعم القضية الفلسطينية بكافة الوسائل المشروعة
                        <br>
                        التأكيد على الحق الثابت للشعب الفلسطيني في أرض فلسطين المباركة
                        <br>
                        توعية الأجيال بتاريخ فلسطين ونضال شعبها وصموده
                        <br>
                        العمل على أن تبقى فلسطين حاضرة في الأذهان والقلوب بغض النظر عن الظروف الوقتية التي تمر بهار الأمة من حين لآخر.
                        <br>
                        التوعية بمفهوم الصهيونية ومدى خطورتها على العالم العربي والإسلامي والتحذير منها، ومقاومة كافة أشكال التوغل الصهيوني في الشؤون العربية والإسلامية
                        <br>
                        العمل على عزل الكيان الصهيوني الغاصب على كافة الأصعدة والمستويات الرسمية والشعبية
                        <br>
                        التوعية بأهمية المقاطعة الاقتصادية الشعبية للعدو الصهيوني في نصرة قضايا الأمة
                        <br>
                        الدعوة إلى مقاطعة المنتجات الصهيونية وغيرها من منتجات الدول الكيان الصهيوني سواء كانت هذه المساندة سياسية أو عسكرية أو اقتصادية أو معنوية أو غيرها
                        <br>
                        نشر روح المبادئ القومية والإسلامية التي يؤكد عليها دستور مملكة البحرين وميثاقها
                    </div>

                </div>
            </div>

        </section>
    {{--end about us  --}}








    {{--Start footer --}}

    <footer style="background-color: var(--primary-color)">

        <div class="container">
            <div class="content d-flex justify-content-between align-items-center">

                <div>

                    <ul class="p-0 m-0">
                        <li class="list-inline-item">
                            <a href="{{route('about.us')}}" class="text-white text-decoration-none">من نحن</a>
                        </li>
                        <li class="list-inline-item text-white">|</li>
                        <li class="list-inline-item">
                            <a href="#" class="text-white text-decoration-none">سياسة الخصوصية</a>
                        </li>
                        <li class="list-inline-item text-white">|</li>
                        <li class="list-inline-item">
                            <a href="#contact" class="text-white text-decoration-none">تواصل معنا</a>
                        </li>
                    </ul>

                </div>

                <div class="text-white pt-2 pb-2">
                    © 2025 جمعية مناصرة فلسطين
                </div>

            </div>
        </div>

    </footer>

    {{-- End Footer --}}



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="{{asset('js/script.js')}}"></script>


</body>
</html>
