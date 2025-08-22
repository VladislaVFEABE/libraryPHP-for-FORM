// Динамическая генерация формы через AJAX
function loadForm(type) {
    fetch('generate.php?form=' + type)
        .then(res => res.text())
        .then(html => {
            document.getElementById('formContainer').innerHTML = html;
        });
}
