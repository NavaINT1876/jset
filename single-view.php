    <div class="content-wrapper">
        <div class="content">
            <h1 class="single-view-title"><?= isset($row) ? $row['title']: '' ?></h1>
            <div class="single-view-text">
                <p><?= isset($row) ? $row['text']: '' ?></p>
            </div>
            <form action="#" method='post' id="comment-form">
                <div class="notify"><p>Message</p></div>
                <h3>Leave your comment:</h3>
                <div class="form-item form-name">
                    <label for="thename">Name: </label>
                    <input type='text' name='thename' id='thename' placeholder="Your name"/>
                </div>
                <div class="form-item form-email">
                    <label for="email">Email: </label>
                    <input type='text' name='email' id='email' placeholder="Your email"/>
                </div>
                <div class="form-item form-comment">
                    <label for="comment">Comment:</label>
                    <textarea name='comment' id='comment' placeholder="Your message"></textarea>
                </div>
                <div class="submit-form">
                    <input type="hidden" name="itemid" id="itemid" value="<?= isset($row) ? $row['id']: '' ?>">
                    <div class="submit-form">
                        <a href="#" onclick="addComment()">
                            <div class="button">Add comment</div>
                        </a>
                    </div>
<!--                    <input type='submit' value='Submit' />-->
                </div>
            </form>
            <div class="comments-list">
                <h3>Comments:</h3>
                <?php foreach($comments as $comment){ ?>
                    <section>
                        <h5><?= $comment['name'] ?> <span>says...</span></h5>
                        <p><?= $comment['message'] ?></p>
                        <div class="comment-date"><?= date('d.m.Y', $comment['created_at']); ?></div>
                    </section>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="page-buffer"></div>