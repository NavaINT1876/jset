<div class="container">
    <div class="row">
        <div class="col-md-2 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
            <?php foreach ($comments as $comment) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="author">
                            <strong><?= $comment['name'] ?></strong>
                        </span>
                        <span class="pull-right">Date: <?= date('d.M.Y H:i', $comment['created_at']) ?></span>
                    </div>
                    <div class="panel-body">
                        <p><?= $comment['message'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-2 col-lg-3"></div>
    </div>
    <div class="row">
        <div class="col-md-2 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Leave your comment</div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="name">Your name (*)</label>
                                    <input type="text" name="name" placeholder="Name" class="form-control" id="name"
                                           required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email address (*)</label>
                                    <input type="email" name="email" placeholder="Email" class="form-control" id="email"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Your message (*)</label>
                            <textarea name="message" placeholder="Your message" rows="4" class="form-control"
                                      id="message" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo image</label>
                            <input type="file" id="logo">
                            <p class="help-block">Allowed types: JPG, GIF, PNG. Maximum resolution: 320х240px</p>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Отправить</button>
                        <a href="#" class="btn btn-default" id="preview">Предварительный просмотр</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-3"></div>
    </div>
</div>