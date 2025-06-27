            
                        <footer class="bg-slate-800 text-slate-300 py-8">
                            <div class="container mx-auto px-6 text-center text-sm">
                                <p>© 2023 Okul Yönetim Sistemi. Tüm hakları saklıdır.</p>
                                <p class="mt-1">Geliştirici Ekip | <a class="hover:text-white" href="#">Gizlilik Politikası</a> | <a
                                        class="hover:text-white" href="#">Kullanım Şartları</a></p>
                            </div>
                        </footer>
                    </div>
                </div>
            <script src="https://cdn.tailwindcss.com"></script> 
            <!-- <script>
            function openAddModal(id = null) {
                if (id) {
                    fetch("transactions/get_student.php?id=" + id)
                        .then(res => res.json())
                        .then(student => {
                            for (const key in student) {
                                const el = document.getElementById(key);
                                if (el) el.value = student[key];
                            }
                            document.getElementById("studentId").value = student.id;
                            document.getElementById("modalTitle").innerText = "Öğrenciyi Düzenle";
                        });
                } else {
                    document.getElementById("studentForm").reset();
                    document.getElementById("modalTitle").innerText = "Yeni Öğrenci Ekle";
                }
                document.getElementById("addModal").classList.remove("hidden");
            }

            let currentPage = 1;
            let perPage = 25;
            let totalPages = 1;

            document.addEventListener("DOMContentLoaded", () => {
                fetchStudents(currentPage, '');
            });

            function fetchStudents(page = 1, query = '') {
                const xhr = new XMLHttpRequest();
                xhr.open("GET", "transactions/search_students.php?page=" + page + "&size=" + perPage + "&query=" + encodeURIComponent(query), true);
                xhr.onload = function () {
                    if (this.status === 200) {
                        try {
                            const res = JSON.parse(this.responseText);
                            document.getElementById("studentTableBody").innerHTML = res.html;
                            document.getElementById("totalStudentCount").textContent = res.total;
                            updatePagination(res.total, page);
                        } catch (e) {
                            console.error("JSON parse hatası:", e);
                            alert("JSON formatında hata oluştu!");
                        }
                    } else {
                        alert("AJAX isteği başarısız.");
                    }
                };
                xhr.send();
            }

            function updatePagination(total, current) {
                currentPage = current;
                totalPages = Math.ceil(total / perPage);
                document.getElementById("pageInfo").textContent = `Sayfa ${current} / ${totalPages}`;
                document.getElementById("prevPage").disabled = currentPage === 1;
                document.getElementById("nextPage").disabled = currentPage === totalPages || totalPages === 0;
            }

            function showDetail(studentData) {
                studentData = JSON.parse(studentData);
                let html = `
                    <p><strong>ID:</strong> ${studentData.id}</p>
                    <p><strong>Ad Soyad:</strong> ${studentData.full_name}</p>
                    <p><strong>Sınıf:</strong> ${studentData.class || '-'}</p>
                    <p><strong>Numara:</strong> ${studentData.school_number || '-'}</p>
                    <p><strong>TC Kimlik:</strong> ${studentData.tc_no || '-'}</p>
                    <p><strong>Cinsiyet:</strong> ${studentData.gender || '-'}</p>
                    <p><strong>Veli Adı:</strong> ${studentData.parent_name || '-'}</p>
                    <p><strong>Durum:</strong> ${studentData.status}</p>
                    <p><strong>Fotoğraf:</strong> ${studentData.photo ? `<img src='${studentData.photo}' class='mt-2 h-20 w-20 object-cover rounded' />` : '-'}</p>
                    <p><strong>Eğitim Dönemi:</strong> ${studentData.education_period || '-'}</p>
                    <p><strong>Kayıt Tarihi:</strong> ${studentData.registration_date || '-'}</p>
                `;
                document.getElementById("detailContent").innerHTML = html;
                document.getElementById("detailModal").classList.remove("hidden");
            }
            function closeDetail() {
                document.getElementById("detailModal").classList.add("hidden");
            }
            function editStudent(id) {
                openAddModal(id);
            }
            function deleteStudent(id) {
                if (confirm("Bu öğrenciyi silmek istediğinize emin misiniz?")) {
                    fetch(`transactions/delete_student.php?id=${id}`)
                        .then(res => res.json())
                        .then(data => {
                            alert(data.message);
                            fetchStudents(currentPage, document.getElementById("searchInput").value.trim());
                        });
                }
            }
            function exportToPDF(id) {
                window.open(`transactions/pdf_export.php?id=${id}`, '_blank');
            }
            </script> -->
            </div>
        </div>
    </body>
</html>