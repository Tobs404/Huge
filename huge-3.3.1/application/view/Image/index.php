<div class="container">
    <h1>ImageController/index</h1>
    <div class="box">

        <?php $this->renderFeedbackMessages(); ?>

        <h3>Image Uploader</h3>
        <form action="<?= Config::get('URL'); ?>Image/UploadImageToModell" method="post" enctype="multipart/form-data">
            <input type="file" name="datei" accept=".jpg,.png,.pdf">
            <button type="submit">Hochladen</button>
        </form>

       <?php if (!empty($this->approvedImages)) : ?>
           <div>
               <?php foreach ($this->approvedImages as $image): ?>
                   <div >
                       <img src="<?= Config::get('URL'); ?>Image/image/<?= urlencode($image->imageHash); ?>"
                        alt="User image"
                        width="350">
                   </div>
               <?php endforeach; ?>
           </div>
       <?php else : ?>
           <p>No Pictures found </p>
       <?php endif; ?>
    </div>
</div>
