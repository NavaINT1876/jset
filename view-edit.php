<div class="container">
    <div class="row" id="form-container">
        <div class="col-md-2 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Edit comment</div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="" method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Name (*)</label>
                                    <input type="text" name="name" placeholder="Name" class="form-control" id="name"
                                           required value="<?= $comment[0]['name'] ?>">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email address (*)</label>
                                    <input type="email" name="email" placeholder="Email" class="form-control" id="email"
                                           required value="<?= $comment[0]['email'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Your message (*)</label>
                            <textarea name="message" placeholder="Your message" rows="4" class="form-control"
                                      id="message" required><?= $comment[0]['message'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo image</label>
                            <input name="logo" type="file" id="logo">
                            <p class="help-block">Allowed types: JPG, GIF, PNG. Maximum resolution: 320х240px</p>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-3"></div>
    </div>
</div>