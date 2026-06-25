<div class="shop-container">
    
    <h1 class="shop-title">HUGE Merchandise Shop</h1>

    <div class="shop-box">

        <?php $this->renderFeedbackMessages(); ?>

        <p class="shop-intro">
            Welcome to our HUGE merchandise shop for all our HUGE lovers!
        </p>

        <?php if (!empty($this->items)) : ?>
            
            <div class="shop-grid">

                <?php foreach ($this->items as $item) : ?>

                    <div class="product-card">

                        <div class="product-image">
                            <img 
                                src="/Huge/huge-3.3.1/public/shopImages/<?php echo htmlspecialchars($item->imageName); ?>"
                                alt="<?php echo htmlspecialchars($item->name); ?>"
                            >
                        </div>

                        <div class="product-content">

                            <h3 class="product-title">
                                <?php echo htmlspecialchars($item->name); ?>
                            </h3>

                            <p class="product-description">
                                <?php echo htmlspecialchars($item->description); ?>
                            </p>

                            <p class="product-price">
                                €<?php echo number_format($item->price, 2); ?>
                            </p>

                            <form action="<?= Config::get('URL'); ?>shop/toBasket/<?= $item->id ?>" method="post">
                                <button type="submit" class="btn-add">
                                    Add to Cart
                                </button>
                            </form>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php else : ?>
            <p class="empty-state">No items available.</p>
        <?php endif; ?>

    </div>
</div>