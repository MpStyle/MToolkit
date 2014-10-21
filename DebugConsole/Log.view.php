<?php
namespace MToolkit\DebugConsole;

use MToolkit\Core\MLog;
use MToolkit\Core\MCoreApplication;
use MToolkit\DebugConsole\Languages\Languages;

/* @var $this Log */
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div id="Content">
    <h1><?php echo Languages::getString( "log_page_title" ) ?></h1>

    <div class="row">

        <h4 class="col-xs-6 col-sm-7 col-md-8 col-lg-8"><?php echo Languages::getString( "log_page_subtitle" ) ?></h4>

        <form method="post" class="col-xs-6 col-sm-5 col-md-4 col-lg-4 text-right">
            <div class="btn-group btn-group-sm">
                <a href="Log.php" class="btn btn-default"><?php echo Languages::getString( "log_page_refresh_log_messages" ) ?></a>
                
                <button type="submit" name="action" value="ClearLogMessages" class="btn btn-default"><?php echo Languages::getString( "log_page_clear_log_messages" ) ?></button>

                <?php if( MCoreApplication::isDebug() ): ?>
                    <button type="submit" name="action" value="DisableDebug" class="btn btn-default"><?php echo Languages::getString( "log_page_disable_debug_mode" ) ?></button>
                <?php else: ?>
                    <button type="submit" name="action" value="EnableDebug" class="btn btn-default"><?php echo Languages::getString( "log_page_enable_debug_mode" ) ?></button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php if( !MCoreApplication::isDebug() ): ?>
        <div class="alert alert-danger text-center" role="alert">
            <strong>Debug mode is disabled</strong>
        </div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><?php echo Languages::getString( "log_page_date_time" ) ?></th>
                    <th><?php echo Languages::getString( "log_page_tag" ) ?></th>
                    <th><?php echo Languages::getString( "log_page_text" ) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if( MLog::getMessages()->count() <= 0 ): ?>
                    <tr>
                        <td colspan="3">No messages</td>
                    </tr>
                <?php endif; ?>
                <?php foreach( MLog::getMessages()->reverse() as /* @var $message \MToolkit\Core\MLogMessage */ $message ): ?>
                    <tr class="log-<?php echo strtolower( $message->getType() ); ?> <?php echo Log::getBootstrapTdClass( $message->getType() ) ?>">
                        <td><?php echo $message->getTime()->format( "Y/m/d H:i:s" ) ?></td>
                        <td><?php echo $message->getTag() ?></td>
                        <td><?php echo $message->getText() ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>