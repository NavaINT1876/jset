<div class="container">
    <div class="row" id="comments-wrapper" data-prototype="
                                            <div class='panel panel-success'>
                                                <div class='panel-heading'>
                                                    <span class='author'>
                                                        <strong>__AUTHOR__ (It's you)</strong>
                                                    </span>
                                                    <span class='pull-right'>Date: moment ago</span>
                                                </div>
                                                <div class='panel-body'>
                                                    <p>__COMMENT_TEXT__</p>
                                                </div>
                                            </div>">
        <div class="col-md-2 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6" id="comments-container">
            <?php
            session_start();
            if(isset($_SESSION['error'])){ ?>
                <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php
            unset($_SESSION['error']);
            } ?>
            <div class="btn-group" role="group">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sort comments by:
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li <?php echo ($sortValue == 'name' && $sortOrder == 'asc') ? 'class="active"' : '' ?>>
                            <a href="/?sortVal=name&sortOrder=asc">Author A -> Z</a>
                        </li>
                        <li <?php echo ($sortValue == 'name' && $sortOrder == 'desc') ? 'class="active"' : '' ?>>
                            <a href="/?sortVal=name&sortOrder=desc">Author Z -> A</a>
                        </li>
                        <li <?php echo ($sortValue == 'email' && $sortOrder == 'asc') ? 'class="active"' : '' ?>>
                            <a href="/?sortVal=email&sortOrder=asc">E-mail A -> Z</a>
                        </li>
                        <li <?php echo ($sortValue == 'email' && $sortOrder == 'desc') ? 'class="active"' : '' ?>>
                            <a href="/?sortVal=email&sortOrder=desc">E-mail Z -> A</a>
                        </li>
                        <li <?php echo ($sortValue == 'created_at' && $sortOrder == 'desc') ? 'class="active"' : '' ?>>
                            <a href="/?sortVal=created_at&sortOrder=desc">Date New -> Old</a>
                        </li>
                        <li <?php echo ($sortValue == 'created_at' && $sortOrder == 'asc') ? 'class="active"' : '' ?>>
                            <a href="/?sortVal=created_at&sortOrder=asc">Date Old -> New</a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php foreach ($comments as $comment) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="author">
                            <strong><?= $comment['name'] ?></strong>
                            <?php if(isset($_SESSION['admin'])){ ?>
                                <a href="/?r=edit&id=<?= $comment['id'] ?>" class="btn btn-primary btn-xs">
                                    <span>Edit</span>
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            <?php } ?>
                        </span>
                        <span class="pull-right">Date: <?= date('d.M.Y H:i', $comment['created_at']) ?></span>
                    </div>
                    <div class="panel-body">
                        <img src="<?= ($comment['logo']) ? $comment['logo'] : 'uploads/sample.jpg' ?>" width="80" alt="Logo" class="user-logo">
                        <p><?= $comment['message'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="col-md-2 col-lg-3"></div>
    </div>
    <div class="row" id="form-container">
        <div class="col-md-2 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Leave your comment</div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" action="" method="post">
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
                            <input name="logo" type="file" id="logo">
                            <p class="help-block">Allowed types: JPG, GIF, PNG. Maximum resolution: 320х240px</p>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary">Отправить</button>
                        <a href="#" class="btn btn-default" id="comment-preview">Предварительный просмотр</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-lg-3"></div>
    </div>
</div>