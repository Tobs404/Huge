<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .checkout-container {
            max-width: 1100px;
            margin: 50px auto;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .order-total {
            font-size: 1.3rem;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container checkout-container">

    <h1 class="mb-4">Checkout</h1>

    <div class="row">

        <!-- Customer Details -->
        <div class="col-lg-8">

            <div class="card p-4 mb-4">
                <h3>Customer Information</h3>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control">
                    </div>

                </div>
            </div>

            <div class="card p-4 mb-4">
                <h3>Shipping Address</h3>

                <div class="mb-3">
                    <label class="form-label">Street Address</label>
                    <input type="text" class="form-control">
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">ZIP Code</label>
                        <input type="text" class="form-control">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control">
                    </div>

                </div>
            </div>

            <div class="card p-4">

                <h3>Payment Method</h3>

                <div class="form-check">
                    <input class="form-check-input" type="radio" checked name="payment">
                    <label class="form-check-label">
                        Credit / Debit Card
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment">
                    <label class="form-check-label">
                        PayPal
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment">
                    <label class="form-check-label">
                        Cash on Delivery
                    </label>
                </div>

            </div>

        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">

            <div class="card p-4">

                <h3>Order Summary</h3>

                <hr>
                 <?php foreach ($this->items as $item) : ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo htmlspecialchars($item->name); ?></span>
                        <span>€<?php echo number_format($item->price, 2); ?></span>
                    </div>

                <?php endforeach; ?>

                <div class="d-flex justify-content-between mb-2">
                    <span>Shipping</span>
                    <span>€5.00</span>
                </div>

                <hr>

                <div class="d-flex justify-content-between order-total mb-4">
                    <span>Total</span>
                    <span>€<?php echo number_format($this->total, 2); ?></span>
                </div>
                
                <form action="<?= Config::get('URL'); ?>basket/submitOrder" method="post">
                    <div>
                        <button class="btn btn-primary w-100 btn-lg">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>