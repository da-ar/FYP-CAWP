<h1><?= $service[0]->name; ?></h1>
<br />
<p><a href="<?= $service[0]->url; ?>" class="button green"><b>Visit:</b> <?= $service[0]->name; ?></a></p>
<br />
<div id="info_details">
        <?= nl2br($service[0]->body); ?>
</div>