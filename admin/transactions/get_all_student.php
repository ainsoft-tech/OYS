<script>
function editStudent(id) {
    openAddModal(id);
}

function openAddModal(id = null) {
    if (id) {
        fetch('transactions/get_student.php?id=' + id)
            .then(res => res.json())
            .then(student => {
                for (const key in student) {
                    var el = document.getElementById(key);
                    if (el && el.type !== 'file') {
                        el.value = student[key];
                    }
                }
                document.getElementById("studentId").value = student.id;
                document.getElementById("modalTitle").innerText = "Öğrenciyi Düzenle";
                document.getElementById("addModal").classList.remove("hidden");
            });
    } else {
        document.getElementById("studentForm").reset();
        document.getElementById("studentId").value = '';
        document.getElementById("modalTitle").innerText = "Yeni Öğrenci Ekle";
        document.getElementById("addModal").classList.remove("hidden");
    }
}
</script>
