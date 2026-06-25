<div class="container">
    <h1>HUGE Merchandise Shop</h1>

    <div class="box">

        <?php $this->renderFeedbackMessages(); ?>

        <p>
            Huge Admin Site Add or Remove current items!
        </p>
        <a href="<?= Config::get('URL') . 'adminshop/addItem/' ?>">Add an Item</a>

        <?php if (!empty($this->items)) : ?>
            <div class="shop-grid">
                <table class="overview-table">
                <thead>
                <tr>
                    <td>Image</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <?php foreach ($this->items as $item) { ?>
                        <td class="avatar">
                            <img src="/Huge/huge-3.3.1/public/shopImages/<?php echo htmlspecialchars($item->imageName); ?>"
                                    width = 150
                                    height = 150
                                 alt="<?php echo htmlspecialchars($item->name) ?>;">
                        </td>
                        <td><?= $item->name; ?></td>
                        <td><?= $item->description ?></td>
                        <td><?= number_format($item->price, 2) ?></td>
                        <td>
                            <a href="<?= Config::get('URL') . 'adminshop/removeItem/' . $item->id; ?>">Remove</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            </div>
        <?php else : ?>
            <p>No items available.</p>
        <?php endif; ?>

    </div>
</div>