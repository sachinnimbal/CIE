$(document).ready(function () {
    (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()


        $("[id='cief'] , [id='cies'] , [id='ciet']").blur(function () { 
        var a = $(this).val();
            if (a < 0 || a > 15) {
                alert("The CIE 1 Marks Should be in between 1 to 15");
                $(this).addClass('bg-danger');
                $(this).val(0)
            } else {
                $(this).removeClass('bg-danger');
            }   
            if (a == 'a' || a == 'A') {
                confirm("Are you sure the Student is Absent ( Press 'OK' if Absent.. )");
            }
        });


        $("[id='assi']").blur(function () { 
        var b = $(this).val();
            if (b < 0 || b > 35) {
                alert("The Assignment Marks Should be in between 1 to 35");
                $(this).addClass('bg-danger');
                $(this).val(0)
            } else {
                $(this).removeClass('bg-danger');
            }            
        });

        $("[id='usn'] , [id='name']").focus(function () {
            $(this).blur();
        });

        var mar = $('#cie').val();
        if (mar == 'CIE1') {
            $("[id='cies'] , [id='ciet'] , [id='assi']").focus(function () {
                $(this).blur();
            });
        } else if (mar == 'CIE2') {
            $("[id='cief'] , [id='ciet'] , [id='assi']").focus(function () {
                $(this).blur();
            });
        } else if (mar == 'CIE3') {
            $("[id='cief'] , [id='cies'] , [id='assi']").focus(function () {
                $(this).blur();
            });
        } else if (mar == 'Assignment') {
            $("[id='cief'] , [id='cies'] , [id='ciet']").focus(function () {
                $(this).blur();
            });
        }


});