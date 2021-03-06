<?php if (isset($_POST['update-cart'])) update_cart(); ?>
<style>
    #cart-list {
        width: 100%;
        max-height: 400px;
        overflow-y: scroll;
        overflow-x: hidden;
        padding: 10px 20px 0 0;
    }

    #cart-list::-webkit-scrollbar {
        width: 5px;
    }

    #cart-list::-webkit-scrollbar-track {
        background: transparent;
    }

    #cart-list::-webkit-scrollbar-thumb {
        background-color: lightgray;
        height: 50px;
        border-radius: 10px;
    }

    .col-12 {
        padding: 0
    }

    .update-cart-btn:hover {
        color: greenyellow
    }

    .product-infor::-webkit-scrollbar {
        display: none;
    }
</style>
<section class="h-100" style="background-color: grey;">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class=" card-registration card-registration-2" style="border-radius: 15px;">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-8 bg-white">
                                <div class="p-5">
                                    <div class="d-flex justify-content-between align-items-center mb-5">
                                        <h1 class="fw-bold mb-0 text-black" id="cart">Shopping Cart</h1>
                                        <h6 class="mb-0 text-muted">Items : <?php echo isset($_SESSION['cart']) ?  count($_SESSION['cart']) : 0 ?>
                                        </h6>
                                    </div>
                                    <!-- product list -->
                                    <div id="cart-list">
                                        <?php
                                        if (isset($_SESSION['cart'])) :
                                            $tempAmount = 0;
                                            $index = 0;
                                            if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                                foreach ($_SESSION['cart'] as $item) :
                                                    extract($item);
                                        ?>
                                                    <hr class="my-4">
                                                    <form action="" method="POST">
                                                        <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                            <div class="col-1" style="width:auto">
                                                                <button type="submit" name="update-cart" class="update-cart-btn border-0 bg-transparent text-muted" onclick="window.location.reload()">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                            </div>
                                                            <div class="col-2">
                                                                <img src=<?= $IMG_ROOT . $image ?> class="img-fluid rounded-3" style="max-width:100px">
                                                            </div>
                                                            <div class="col-4 product-infor overflow-auto">
                                                                <h6 class="text-black mb-2 text-nowrap"><?php echo $name ?></h6>
                                                                <h6 class="mb-0 price text-secondary"><?php echo "$" . $price ?></h6>
                                                            </div>
                                                            <div class="col-1 d-flex">
                                                                <input type="hidden" class="" name="index" value=<?php echo $index ?>>
                                                                <input type="hidden" class="" name="product_id" value=<?php echo $id ?>>
                                                                <input type="hidden" class="" name="product_img" value=<?php echo $image ?>>
                                                                <input type="hidden" class="" name="product_name" value=<?php echo $name ?>>
                                                                <input type="hidden" class="price border-0 bg-transparent fs-5 fw-semi-bold" name="price" value=<?= $price ?>>
                                                                <input type="hidden" class="total border-0 bg-transparent fs-5 fw-semi-bold" name="total" value=<?= $total ?>>
                                                                <div class=" d-flex">
                                                                    <input min="1" name="quantity" value=<?= $qty ?> type="number" class="form-control" style="width:3.5rem" oninput="getTotalPrice(this)" />
                                                                </div>
                                                            </div>
                                                            <div class="col-2 offset-lg-1">
                                                                <h6 class="mb-0 total-price"><?= '$' . $total ?></h6>
                                                            </div>
                                                            <div class="col-1 text-end">
                                                                <a href=<?= "?page=cart-list&del_id={$index}#cart" ?> class="delete-btn text-muted"><i class="fas fa-times"></i></a>
                                                            </div>
                                                        </div>
                                                    </form>
                                        <?php
                                                    $index++;
                                                    $tempAmount += $total;
                                                endforeach;
                                            } else echo "<span class='text-muted fs-2 text-uppercase'>Your cart list is empty!</span>";
                                        endif;
                                        ?>
                                    </div>
                                    <div class="pt-5">
                                        <h6 class="mb-0"><a href="?page=products&cate=all&tabindex=1" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 bg-grey h-100 rounded-0">
                                <div class="p-5">
                                    <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between mb-4">
                                        <label class="text-uppercase fw-bold">Temporary Payment :</label>
                                        <h5 id="temp-amount" data=<?= $tempAmount ?>><?= "$" . $tempAmount ?></h5>
                                    </div>
                                    <div class="mb-4 pb-2">
                                        <label for="" class="form-label text-uppercase"></label>
                                        <select class="form-select-lg w-100" id="delivery">
                                            <option value=" 0">Receive Directly From Shop</option>
                                            <option value="10">Standard-Delivery - $10.00</option>
                                            <option value="20">Express-Delivery - $20.00</option>
                                        </select>
                                    </div>
                                    <!-- gift code -->
                                    <div class="mb-5">
                                        <div class="form-outline">
                                            <label class="form-label text-uppercase" for="form3Examplea2">Gift Code</label>
                                            <input type="password" id="gift-code" class="form-control form-control-lg" />
                                            <span style="font-size: 1rem;" id="gift-code-message"></span>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <form action="?page=cart-list" method="POST">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h5 class="text-uppercase">Total price:</h5>
                                            <h4 class="text-uppercase" id="total-amount-label"><?= $tempAmount ?></h4>
                                            <input type="hidden" id="total-amount" name="total">
                                        </div>
                                        <button type="submit" class="btn btn-dark btn-block btn-lg" name="place-order" data-mdb-ripple-color="dark">Place Order</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="./js/cart-list.js"></script>