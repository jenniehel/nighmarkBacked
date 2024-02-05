<?php
// 导入数据库连接
// require __DIR__ . '/components/connectToSql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
?>

<style>
    form .mb-3 .form-text {
        color: red;
    }

    .is-invalid {
        border: 1px solid red;
    }

    #timeError {
        color: red;
    }
</style>

<div class="container mt-3">
    <h2>新增產品</h2>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form name="form1" method="post" onsubmit="sendForm(event)" enctype="multipart/form-data">
                        <!-- 在这里添加表单输入框，根据需要调整 -->
                        <div class="mb-3">
                            <label for="product_name" class="form-label">產品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">產品類別</label>
                            <!-- 在这里添加下拉菜单，根据需要调整 -->
                            <select class="form-select" id="category" name="category">
                                <option value="點心">點心</option>
                                <option value="飲料">飲料</option>
                                <option value="甜品">甜品</option>
                                <option value="湯品">湯品</option>
                                <option value="小吃">小吃</option>
                                <option value="主食">主食</option>
                            </select>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_description" class="form-label">產品敘述</label>
                            <textarea class="form-control" id="product_description" name="product_description"
                                rows="3"></textarea>
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="image_url" class="form-label">產品圖片</label>
                            <input type="file" class="form-control" id="image_url" name="image_url" min="1">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">產品價格</label>
                            <input type="number" class="form-control" id="price" name="price">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="listing_date" class="form-label">上架日期</label>
                            <input type="date" class="form-control" id="listing_date" name="listing_date">
                            <div class="form-text">該欄位必填</div>
                        </div>

                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label">總數量</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="1">
                            <div class="form-text">該欄位必填</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary">新增資料</button>
                            </div>

                            <div class="mt-1">
                                <a href="list.php">回到產品列表</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 添加 Bootstrap Modal 部分 -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">成功提示</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="successModalBody">
                <!-- 提示框內容 -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="continueEditingButton">繼續編輯</button>
                <button type="button" class="btn btn-primary" id="redirectToButton">回列表</button>
            </div>
        </div>
    </div>
</div>
<script>
    function sendForm(event) {
        event.preventDefault(); // 阻止表單提交

        // 獲取表單數據
        const formData = new FormData(document.forms.form1);

        function validateForm() {
            let isValid = true;

            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
            });
            document.querySelectorAll('.form-text').forEach(errorMsg => {
                errorMsg.innerText = '';
            });

            // 添加額外的驗證邏輯
            if (!formData.get('product_name') || (formData.get('product_name') && formData.get('product_name').trim() === '')) {
                document.forms.form1.product_name.classList.add('is-invalid');
                document.forms.form1.product_name.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            }
            if (!formData.get('product_description') || formData.get('product_description').trim() === '') {
                document.forms.form1.product_description.classList.add('is-invalid');
                document.forms.form1.product_description.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            }
            if (!formData.get('image_url')) {
                document.forms.form1.image_url.classList.add('is-invalid');
                document.forms.form1.image_url.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            } else {
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
                const fileName = formData.get('image_url').name;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    document.forms.form1.image_url.classList.add('is-invalid');
                    document.forms.form1.image_url.nextElementSibling.innerText = '僅接受 jpg、jpeg、png 和 webp 格式的圖片';
                    isValid = false;
                }
            }
            if (!formData.get('price') || isNaN(formData.get('price'))) {
                document.forms.form1.price.classList.add('is-invalid');
                document.forms.form1.price.nextElementSibling.innerText = '該欄位必填且必須為數字';
                isValid = false;
            }
            if (!formData.get('listing_date')) {
                document.forms.form1.listing_date.classList.add('is-invalid');
                document.forms.form1.listing_date.nextElementSibling.innerText = '該欄位必填';
                isValid = false;
            } else {
                const dateRegex = /^\d{4}-\d{2}-\d{2}$/; // 簡單的日期格式檢查，例如：YYYY-MM-DD

                if (!dateRegex.test(formData.get('listing_date'))) {
                    document.forms.form1.listing_date.classList.add('is-invalid');
                    document.forms.form1.listing_date.nextElementSibling.innerText = '日期格式應為 YYYY-MM-DD';
                    isValid = false;
                }
            }


            return isValid;
        }


        // 添加 fetch 到 validateForm 內
        if (validateForm()) {
            // 使用 fetch 進行提交
            fetch('add-api.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // 處理伺服器返回的數據
                    if (data.success) {
                        // 添加成功，顯示提示框
                        showAlert('新增成功', function () {
                            // 繼續編輯，清除表單
                            document.forms.form1.reset();
                        }, function () {
                            // 跳轉回列表
                            window.location.href = data.redirect;
                        });
                    } else {
                        // 添加失敗，處理錯誤信息
                        console.error(data.error);
                    }
                })
                .catch(error => {
                    console.error('Error during fetch:', error);
                });

        }
        
        function showAlert(message, continueEditingCallback, redirectToCallback) {
            // 使用 Bootstrap 的 Modal 顯示提示框
            var modal = new bootstrap.Modal(document.getElementById('successModal'));
            var modalBody = document.getElementById('successModalBody');
            var continueEditingButton = document.getElementById('continueEditingButton');
            var redirectToButton = document.getElementById('redirectToButton');

            modalBody.innerText = message;

            continueEditingButton.addEventListener('click', function () {
                modal.hide();
                continueEditingCallback();
            });

            redirectToButton.addEventListener('click', function () {
                modal.hide();
                redirectToCallback();
            });

            modal.show();
        }
    }
</script>

<?php 
// include __DIR__ . '/components/scripts.php'
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';
 ?>