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
                    <td></td>
                </tr>
                </thead>
                <?php foreach ($this->orders as $order) { ?>
                    <tr>
                        <td><?= htmlspecialchars($order->customer); ?></td>
                        <td><?= htmlspecialchars($order->price, 2); ?></td>
                        <td>
                            <?= htmlspecialchars($order->items ?? ''); ?>
                        </td>
                        <td>
                            <form action="<?= Config::get('URL'); ?>adminshop/UpdateOrderStatus" method="post">
                                <input type="hidden" name="orderId" value="<?= $order->orderID ?>">

                                <select name="status">
                                    <option value="Open" <?= $order->orderStatus == 'Open' ? 'selected' : '' ?>>Open</option>
                                    <option value="Processing" <?= $order->orderStatus == 'Processing' ? 'selected' : '' ?>>Processing</option>
                                    <option value="Shipped" <?= $order->orderStatus == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                    <option value="Completed" <?= $order->orderStatus == 'Completed' ? 'selected' : '' ?>>Completed</option>
                                </select>

                                <button type="submit">Update</button>
                            </form>
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