<?php
@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();
$module = NewsletterApi::$instance;

if (!$controls->is_action()) {
    $controls->data = $module->options;
} else {
    if ($controls->is_action('save')) {
        $module->save_options($controls->data);
        $controls->messages = 'Saved.';
    }
}
?>

<div class="wrap" id="tnp-wrap">
    <?php include NEWSLETTER_DIR . '/tnp-header.php' ?>
    <div id="tnp-heading">
        <h2>Newsletter API</h2>
        <?php $controls->page_help('https://www.thenewsletterplugin.com/documentation/newsletter-api') ?>
    </div>
    <div id="tnp-body">
        <form action="" method="post">
            <?php $controls->init(); ?>
            <table class="form-table">
                <tr>
                    <th>API Key</th>
                    <td>
                        <?php $controls->text('key', 50); ?>
                    </td>
                </tr>
            </table>
            <p class="submit">
                <?php $controls->button_primary('save', 'Save'); ?>

            </p>
        </form>
    </div>
    <?php @include NEWSLETTER_DIR . '/tnp-footer.php' ?>
</div>