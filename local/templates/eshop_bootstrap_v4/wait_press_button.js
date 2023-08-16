document.addEventListener("DOMContentLoaded", function () {

    const closeButton = document.querySelector('.modal__close')
    const succesCloseButton = document.querySelector('.success__modal__close')
    const failureCloseButton = document.querySelector('.failure__modal__close')
    const submitButton = document.querySelector('.send-button')

    let form = document.getElementById("custom_modal")
    let successForm = document.getElementById('success_modal')
    let failureForm = document.getElementById('failure_modal')
    let mainForm = document.getElementById("modal__main")

    function showSubmitForm(selected_text, src_url) {
        form.style.display = "flex"

        getSelection().removeAllRanges()
        document.getElementById("selected-text").innerText = selected_text
        document.getElementById("src_url").innerText = src_url
    }


    function showNoSelectionAlert() {
        alert('Чтобы отправить ошибку администратору необходимо выделить текст с ошибкой и только потом нажать комбинацию клавиш ctrl+enter')
    }

    document.addEventListener("keyup", function (event) {
        if (event.ctrlKey && event.key === "Enter") {
            if (window.getSelection().rangeCount > 0 && window.getSelection() != "") {
                let selected_text = getSelection().toString().trim()
                let src_url = window.location.href
                showSubmitForm(selected_text, src_url)
            } else {
                showNoSelectionAlert()
            }
            isEnterPressed = true
        }
    });


    closeButton.addEventListener("click", function () {
        closeForm()
        resetForm()
    })
    succesCloseButton.addEventListener("click", function () {
        closeForm()
        resetForm()
        mainForm.classList.remove("hidden")
        successForm.classList.add("d-none")
    })

    failureCloseButton.addEventListener("click", function () {
        closeForm()
        resetForm()
    })

    function closeForm() {
        form.style.display = "none"
    }

    function resetForm() {
        document.getElementById("correct-variant").value = ""
        document.getElementById("selected-text").innerText = ""
        document.getElementById("src_url").innerText = ""
    }

    submitButton.addEventListener("click", function (event) {

        let correctVariantInput = document.getElementById('correct-variant').value
        let selectedText = document.getElementById('selected-text').textContent
        let srcUrlSpan = document.getElementById('src_url').textContent

        // Отправляем ajax запрос
        event.preventDefault(); // Предотвращаем отправку формы по умолчанию


        // Создаем AJAX запрос
        let xhr = new XMLHttpRequest()
        xhr.open("POST", "/local/templates/eshop_bootstrap_v4/send_email.php", true)
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")

        // Создаем строку параметров для запроса
        let params = "correctVariantInput=" + encodeURIComponent(correctVariantInput) +
            "&selectedText=" + encodeURIComponent(selectedText) +
            "&srcUrlSpan=" + encodeURIComponent(srcUrlSpan)

        xhr.send(params);


        // Добавляем логику после успешной отправки
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {

                mainForm.classList.add("hidden")
                successForm.classList.remove("d-none")
            } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200) {
                alert('Что-то пошло не так, пожалуйста попробуйте повторить позже')
            }
        };
    });

})
