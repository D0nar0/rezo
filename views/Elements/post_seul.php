<div class="card mb-5" id="post_<?= $post->id; ?>">
		<div class="card-header">

			<div class="row">
				<div class="col-8">
					Le <?= date('d/m/Y', strtotime($post->created)); ?> par 
					<a href="feed_user.php?id=<?= $post->User->id; ?>">
						<?= $post->User->pseudo; ?>
					</a>
				</div>
				<div class="col-2">
					<?= $post->nbLikes; ?> 
					<img src="assets/img/like.png" style="height: 24px;" />
				</div>
				<div class="col-2">
				<?php
				// Like ou pas
				if ($post->liked) {
					// Post liké, bouton "unlike"
					$form = new BootstrapForm('Unlike', 'Like', METHOD_POST);

				    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $post->id]);
					$form->setSubmit('Unlike', ['color' => WARNING, 'class' => 'btn-sm float-end']);
					
					echo $form->form();
				} else {
					// Post non liké, bouton "like"
					$form = new BootstrapForm('Nouveau Like', 'Like', METHOD_POST);

				    $form->addInput('post_id', TYPE_HIDDEN, ['value' => $post->id]);
					$form->setSubmit('Like', ['color' => SUCCESS, 'class' => 'btn-sm float-end']);
					
					echo $form->form();
				}
				?>
				</div>
			</div>
			
		</div>
		
		<div class="card-body">
			<div class="row">
				<div class="col col-sm-8">
		    		<h5 class="card-title"><?= $post->title; ?></h5>
		    		<p class="card-text"><?= $html->toHtml($post->content) ;?></p>
		    	</div>
		    </div>
	    </div>

		<div class="card-footer mt-3">
			<?= $html->button('Voir le post', 
			['dir' => 'posts', 'page' => 'one', 'options' => ['id' => $post->id]],
			['color' => SUCCESS, 'class' => 'btn-sm']); ?>
	    </div>
    </div>

	   