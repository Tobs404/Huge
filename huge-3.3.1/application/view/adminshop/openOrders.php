<div class="container">
    <h1>HUGE Merchandise Shop</h1>

    <div class="box">

        <?php $this->renderFeedbackMessages(); ?>

        <p>
            All Current Orders
        </p>
        <?php if (!empty($this->orders)) : ?>
            <div class="shop-grid">
                <table class="overview-table">
                <thead>
                <tr>
                    <td>user</td>
                    <td>Amount</td>
                    <td>Artikel Nummern</td>
                    <td>Actions</td>
                </tr>
                </thead>
                <?php foreach ($this->orders as $order) { ?>
                    <tr>
                        <td><?= htmlspecialchars($order->customer); ?></td>
                        <td><?= htmlspecialchars($order->price, 2); ?></td>
                        <td>
                            <?= htmlspecialchars($order->items ?? ''); ?>
                        </td>
                        <td><?= htmlspecialchars($order->orderStatus); ?></td>
                    </tr>
                <?php } ?>
            </table>
            </div>
        <?php else : ?>
            <p>No items available.</p>
        <?php endif; ?>

    </div>
</div>