<div class="container">
    <h1>HUGE Merchandise Shop</h1>

    <div class="box">

        <?php $this->renderFeedbackMessages(); ?>

        <p>
            This is youre Basket. Here you can see all the items you have added to your basket and remove them if you want to.
        </p>

        <?php if (!empty($this->items)) : ?>
            <div class="shop-grid">
            
                <?php foreach ($this->items as $item) : ?>
                    
                    <div class="product-card">
                        <div class="product-image">
                            <img src="/Huge/huge-3.3.1/public/shopImages/<?php echo htmlspecialchars($item->imageName); ?>"
                                    width = 150
                                    height = 150
                                 alt="<?php echo htmlspecialchars($item->name) ?>;">
                        </div>

                        <h3><?php echo htmlspecialchars($item->name); ?></h3>

                        <p class="product-description">
                            <?php echo htmlspecialchars($item->description); ?>
                        </p>

                        <p class="product-price">
                            €<?php echo number_format($item->price, 2); ?>
                        </p>

                        <form action="<?= Config::get('URL'); ?>basket/removeFromBasket/<?= $item->id ?>" method="post">
                            <div>
                                <input type="hidden" name="groupID" value="<?= $item->id ?>">
                                <button type="submit">Remove from Cart</button>
                            </div>
                        </form>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php else : ?>
            <p>No items available.</p>
        <?php endif; ?>

        <li <?php if (View::checkForActiveControllerAndAction($filename, "Shop/checkout")) { echo ' class="active" '; } ?> >
            <a href="<?php echo Config::get('URL'); ?>Basket/loadCheckout">Checkout</a>
        </li>

    </div>
</div>