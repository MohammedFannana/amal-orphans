//
function toggleFaq(id) {
    const answer = document.getElementById(id);
    const toggle = answer.previousElementSibling.querySelector(".faq-toggle");
    const question = answer.previousElementSibling;

    if (answer.classList.contains("show")) {
        answer.classList.remove("show");
        toggle.textContent = "+";
        question.classList.remove("no-border");
    } else {
        answer.classList.add("show");
        toggle.textContent = "×";
        question.classList.add("no-border");
    }
}

//custom-file-upload   (file uplode button)

// in actions in table in index page
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".show-action").forEach(item => {
        item.addEventListener("click", function (event) {
            event.stopPropagation(); // Prevent click from propagating
            let actionMenu = this.parentElement.querySelector(".action");

            // Hide all other action menus before showing the clicked one
            document.querySelectorAll(".action").forEach(menu => {
                if (menu !== actionMenu) {
                    menu.style.display = "none";
                }
            });

            // Toggle the clicked action menu
            actionMenu.style.display = (actionMenu.style.display === "block") ? "none" : "block";
        });
    });

    // Hide the menu when clicking anywhere outside
    document.addEventListener("click", function (event) {
        document.querySelectorAll(".action").forEach(menu => {
            if (!menu.contains(event.target)) {
                menu.style.display = "none";
            }
        });
    });
});


//this code to show image in input when create any thing need image
document.querySelectorAll('.hidden-file-style').forEach((input, index) => {
    input.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (!file) return;

        const wrapper = document.querySelectorAll('.custom-file-upload')[index] || input.closest('label');
        if (!wrapper) return;

        const fileType = file.type;

        const reader = new FileReader();
        reader.onload = function (e) {
            // أولاً، نحذف أي وسائط قديمة
            wrapper.querySelectorAll('img').forEach(el => el.remove());

            if (fileType.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = "40px"; // أو "100%" أو أي قيمة مناسبة
                wrapper.appendChild(img);

            }
        };

        reader.readAsDataURL(file);
    });
});




// for delete button
$('.btn-delete').click(function(e) {
    let form = $(this).next();
    Swal.fire({
        title: 'هل أنت متأكد?',
        text: "لن تتمكن من التراجع عن هذا!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'إلغاء',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'حذف!'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    })
});


// for disease_type in add new orphan pages
document.addEventListener("DOMContentLoaded", function () {
    const healthGood = document.getElementById("health-good");
    const healthSick = document.getElementById("health-sick");
    const diseaseTypeDiv = document.getElementById("disease_type");

    function toggleDiseaseType() {
        if (healthSick.checked) {
            diseaseTypeDiv.style.display = "block";
        } else {
            diseaseTypeDiv.style.display = "none";
            // optional: إزالة الاختيار السابق عند الإخفاء
            const radios = diseaseTypeDiv.querySelectorAll('input[type="radio"]');
            radios.forEach(r => r.checked = false);
        }
    }

    // تشغيل عند تغيير القيمة
    healthGood.addEventListener("change", toggleDiseaseType);
    healthSick.addEventListener("change", toggleDiseaseType);

    // تشغيل عند تحميل الصفحة (إذا فيه قيمة محفوظة مسبقًا)
    toggleDiseaseType();
});


// for average and academic_stage
document.addEventListener('DOMContentLoaded', function () {
    const educationRadios = document.querySelectorAll('input[name="educational_status"]');
    const academicStageDiv = document.getElementById('academic_stage');
    const averageDiv = document.getElementById('average1');

    function toggleEducationFields() {
        const selected = document.querySelector('input[name="educational_status"]:checked');
        if (selected && selected.value === 'يدرس') {
            academicStageDiv.style.display = 'block';
            averageDiv.style.display = 'block';
        } else {
            academicStageDiv.style.display = 'none';
            averageDiv.style.display = 'none';

            // إلغاء اختيار المرحلة الدراسية والمعدل عند الإخفاء
            const academicInputs = academicStageDiv.querySelectorAll('input[type="radio"]');
            academicInputs.forEach(i => i.checked = false);
            const avgInput = document.getElementById('average');
            if (avgInput) avgInput.value = '';
        }
    }

    // عند تغيير أي اختيار في الوضع التعليمي
    educationRadios.forEach(radio => {
        radio.addEventListener('change', toggleEducationFields);
    });

    // للتأكد من ظهور الحقول إذا كانت القيمة محفوظة مسبقاً
    toggleEducationFields();
});



