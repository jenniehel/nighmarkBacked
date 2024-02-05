<?php
// require __DIR__ . '/admin-required.php';

// require __DIR__ . '/parts/db connect2.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';

$pageName = "add";
$title = "新增";



$sql_customers = "SELECT * FROM custom";
$stmt_customers = $pdo->query($sql_customers);
$customers = $stmt_customers->fetchAll(PDO::FETCH_ASSOC);

$sql_products = "SELECT * FROM products";
$stmt_products = $pdo->query($sql_products);
$products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);


?>



<?php 
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
// include __DIR__ . '/parts/html-head.php';
// include __DIR__ . '/parts/navbar.php' ?>
<style>
  /* 新增 */
  form .form-text {
    color: red;
  }

  .ft {
    background-color: white;
    border-radius: 10px;
    border: 1px solid rgba(221, 235, 255);
  }

  .form-select {
    background-color: rgba(221, 235, 255, 0.5);
  }

  .form-control {
    background-color: rgba(221, 235, 255, 0.5) !important;

  }
</style>
<div class="container">
  <div class="row">
    <div class="clo">
      <div class="card my-5 ">
        <div class="card-body col-10  mx-auto">
          <h2 class=" my-4 text-center">新增資料</h2>
          <!-- <hr> -->
          <!-- 表單 -->
          <form name="form1" method="post" onsubmit="sendForm(event)">
            <!-- 新增顧客訂單 -->

            <!-- 1外框ft start -->
            <div class=" px-5 ft">
              <!-- 顧客選項start -->
              <h4 class="mt-5 mb-4">【基本資料】</h4>
              <div class="mb-3">
                <label for="custom_Id" class="form-label">顧客姓名</label>
                <select id="custom_Id" name="custom_Id" class="form-select" aria-label="Default select example">
                  <option selected value="0">請選擇顧客</option>
                  <?php foreach ($customers as $customer) : ?>
                    <option value="<?= $customer['custom_Id'] ?>">
                      顧客ID:<?= $customer['custom_Id'] ?>
                      顧客姓名:<?= $customer['custom_name'] ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="form-text"></div>
              </div><!-- 顧客選項END -->

              <!-- 付費選項start -->
              <div class="mb-5">
                <label for="payment_method" class="form-label">付費方式</label>
                <select id="payment_method" name="payment_method" class="form-select" aria-label="Default select example">
                  <option selected value="0">請選擇付費方式</option>
                  <option value="信用卡">信用卡</option>
                  <option value="Line_pay">Line pay</option>
                </select>
                <div class="form-text"></div>
              </div><!-- 付費選項END -->
            </div><!-- 1外框ft end -->


            <!-- 2外框ft start -->
            <div class=" px-5 ft mt-3">
              <h4 class="mt-5">【選購商品】</h4>
              <div class="product-fields-container">
                <div class="product-field mt-5">
                  <!-- 選擇商品與數量並排格式start -->
                  <div class="d-flex felx-column justify-content-between">
                    <!-- 選擇商品START -->
                    <div class="mb-3 col-6">
                      <label class="form-label">選擇商品</label>

                      <select name="product_id[]" class="form-select product-select" aria-label="Default select example" onchange="updatePrice(this)">
                        <option selected value="0">請選擇商品</option>
                        <?php foreach ($products as $product) : ?>
                          <option value="<?= $product['product_id'] ?>" data-price="<?= $product['price'] ?>">
                            商品ID:<?= $product['product_id'] ?>
                            商品名:<?= $product['product_name'] ?>
                            商品單價:<?= $product['price'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>

                      <div class="form-text"></div>
                    </div><!-- 選擇商品END -->


                    <div class="mb-1 col-5">
                      <label class="form-label">購買數量</label>
                      <input type="number" class="form-control order-quantity" name="order_quantity[]" min="1" value="1">
                      <div class="form-text"></div>
                    </div>
                  </div> <!-- 選擇商品與數量並排格式end -->


                  <!-- 小計格式 START -->
                  <div class="d-flex justify-content-end">
                    <div class="mb-5 col-5">
                      <label class="form-label">小計</label>
                      <input type="text" class="form-control subtotal" name="subtotal[]" readonly value="0">
                      <div class="form-text"></div>
                    </div>
                    <input type="hidden" name="price[]" value="0">
                  </div><!-- 小計格式 END -->
                  <hr>
                </div><!-- product-field END -->
              </div><!-- product-fields-container  END-->


              <div class="d-flex justify-content-end my-5">
                <button type="button" class="btn btn-outline-primary px-4" onclick="addProductField()"><i class="fa-solid fa-plus"></i> 新增商品</button>
              </div>
            </div><!-- 2外框ft end -->

            <!-- 3外框ft start -->
            <div class=" px-5 ft mt-3">
              <div class=" mt-5 mb-5">
                <label for="total_amount" class="form-label">總金額</label>
                <input id="total_amount" type="text" class="form-control mb-1 total-amount" name="total_amount" readonly value="0">
                <div class="form-text"></div>
              </div>

              <div class="d-flex justify-content-end my-3">
                <button type="submit" class="btn btn-primary px-5 btn-lg">新增訂單</button>
              </div>
            </div><!-- 3外框ft end-->
          </form>
        </div><!-- class card-body -->
      </div><!-- class card -->

    </div><!-- class clo6 -->
  </div><!-- class row -->

</div> <!-- container END -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">新增結果</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        新增成功
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">繼續新增</button>
        <a type="button" class="btn btn-primary" href="./list.php">回到列表</a>
      </div>
    </div>
  </div>
</div>
<!-- Modal  END-->


<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';


// include __DIR__ . '/parts/scripts.php' ;

// include __DIR__ . '/parts/html-foot.php'; 
?>
<script>
  // 更新每個產品的小計和整個訂單的總金額
  function updateSubtotalAndTotal() {
    let totalAmount = 0;

    // 獲取包含所有商品選擇欄位
    const productFieldsContainer = document.querySelector('.product-fields-container');
    // 獲取所有商品欄位
    const productFields = productFieldsContainer.querySelectorAll('.product-field');

    // 跑過每一個產品
    productFields.forEach((productField, index) => {
      // 獲取商品選擇框、購買數量輸入框和小計輸入框
      const productSelect = productField.querySelector('.product-select');
      const orderQuantityInput = productField.querySelector('.order-quantity');
      const subtotalInput = productField.querySelector('.subtotal');

      // 獲取所選商品的價格和購買數量
      const selectedProductIndex = productSelect.selectedIndex;
      const productPrice = parseFloat(productSelect.options[selectedProductIndex].getAttribute('data-price'));
      const orderQuantity = parseInt(orderQuantityInput.value);

      // 計算小計
      const subtotal = productPrice * orderQuantity;
      // 更新小計欄位
      subtotalInput.value = isNaN(subtotal) ? '' : subtotal.toFixed(0);

      // 累計小計以計算總金額
      totalAmount += isNaN(subtotal) ? 0 : subtotal;
    });

    // 獲取顯示總金額的輸入框並更新其值
    const totalAmountInput = document.querySelector('.total-amount');
    totalAmountInput.value = totalAmount.toFixed(0);
  }




  // 當 HTML 文件已完全載入和解析時觸發
  document.addEventListener('DOMContentLoaded', function() {
    // 獲取包含所有商品選擇欄位
    const productFieldsContainer = document.querySelector('.product-fields-container');

    // 將 updateSubtotalAndTotal 函式附加到容器的 change 和 input 事件上
    productFieldsContainer.addEventListener('change', updateSubtotalAndTotal);
    productFieldsContainer.addEventListener('input', updateSubtotalAndTotal);
  });

  // 動態添加一個新的產品欄
  function addProductField() {
    const productFieldsContainer = document.querySelector('.product-fields-container');
    const productFieldTemplate = document.querySelector('.product-field');
    // 複製模板
    const newProductField = productFieldTemplate.cloneNode(true);

    // 設定初始值
    // 顯示新欄位
    newProductField.style.display = 'block';

    // 清空新商品所有的值
    const productSelect = newProductField.querySelector('.product-select');
    productSelect.selectedIndex = 0;

    const orderQuantityInput = newProductField.querySelector('.order-quantity');
    orderQuantityInput.value = 1;

    const subtotalInput = newProductField.querySelector('.subtotal');
    subtotalInput.value = '0';

    // 添加新商品選擇區域到容器中
    productFieldsContainer.appendChild(newProductField);

    // 為新的商品選擇框和購買數量輸入框添加事件監聽器
    const newProductSelect = newProductField.querySelector('.product-select');
    const newOrderQuantityInput = newProductField.querySelector('.order-quantity');
    newProductSelect.addEventListener('change', updateSubtotalAndTotal);
    newOrderQuantityInput.addEventListener('input', updateSubtotalAndTotal);
  }



  // 當選擇商品的下拉框發生變化時，更新價格和小計
  function updatePrice(select) {
    let selectedOption = select.options[select.selectedIndex];
    let selectedPrice = selectedOption.getAttribute('data-price');
    let parentField = select.closest('.product-field');
    let subtotalInput = parentField.querySelector('.subtotal');
    let priceInput = parentField.querySelector('[name="price[]"]');
    // 更新小計和隱藏price的值
    let quantity = parentField.querySelector('.order-quantity').value;
    let subtotal = selectedPrice * quantity;
    subtotalInput.value = subtotal;
    priceInput.value = selectedPrice;

    // 更新整個訂單的總金額
    updateSubtotalAndTotal();
  }

  // 表單提交時的驗證判斷
  const sendForm = e => {
    e.preventDefault();

    let isPass = true;

    // 顧客姓名
    const customIdSelect = document.getElementById('custom_Id');
    const customText = customIdSelect.nextElementSibling; // form-text element
    if (customIdSelect.value === '0') {
      isPass = false;
      customText.innerText = '請選擇顧客姓名';
      customIdSelect.classList.add('is-invalid');
    } else {
      customText.innerText = '';
      customIdSelect.classList.remove('is-invalid');
    }

    // 付費方式
    const paymentMethodSelect = document.getElementById('payment_method');
    const paymentMethodText = paymentMethodSelect.nextElementSibling; // form-text element
    if (paymentMethodSelect.value === '0') {
      isPass = false;
      paymentMethodText.innerText = '請選擇付費方式';
      paymentMethodSelect.classList.add('is-invalid');
    } else {
      paymentMethodText.innerText = '';
      paymentMethodSelect.classList.remove('is-invalid');
    }

    // 商品選擇
    const productSelects = document.querySelectorAll('.product-select');
    productSelects.forEach((select, index) => {
      const productText = select.nextElementSibling; // form-text element
      if (select.value === '0') {
        isPass = false;
        productText.innerText = '請選擇商品';
        select.classList.add('is-invalid');
      } else {
        productText.innerText = '';
        select.classList.remove('is-invalid');
      }
    });

    //商品數量
    const orderQuantityInputs = document.querySelectorAll('.order-quantity');
    orderQuantityInputs.forEach((input, index) => {
      const orderQuantityText = input.nextElementSibling; // form-text element
      if (!input.value || parseInt(input.value) === 0) {
        isPass = false;
        orderQuantityText.innerText = '請輸入數量';
        input.classList.add('is-invalid');
      } else {
        orderQuantityText.innerText = '';
        input.classList.remove('is-invalid');
      }
    });


    if (isPass) {
      const fd = new FormData(document.form1);

      fetch('add-api.php', {
          method: 'POST',
          body: fd,
        }).then(r => r.json())
        .then(result => {
          console.log({
            result
          });
          if (result.success) {
            myModal1.show();
          }
        }).catch(ex => console.log(ex))
    }
  }

  const myModal1 = new bootstrap.Modal(document.getElementById('exampleModal'));
</script>
