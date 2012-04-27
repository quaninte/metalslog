<script language="javascript" type="text/javascript" src="<?php echo $this->base; ?>/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $this->base; ?>/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->base; ?>/jquery.jqplot.css" />
<ul>
<?php
    foreach ($tests as $test) {
        echo $this->Html->tag('li', $this->Html->link($test['Test']['created'], array(
                    'controller' => 'test',
                    'action' => 'charts',
                    $test['Test']['id'],
                )));
    }
?>
</ul>
    <br />
<?php
if (isset($test)) {
    echo $this->Html->tag('h2', $test['Test']['created']);
}
if (isset($metals)) {
    foreach ($metals as $key => $metal) {
?>
    <div id="chart-<?php echo $key; ?>" style="width: 520px; display: inline-block;"></div>
    <script type="text/javascript">
        $(document).ready(function() {
            data = [[
            <?php
                $i = 0;
                foreach ($metal as $metalPrice) {
                    $i++;
            ?>
                            [<?php echo $i; ?>, <?php echo $metalPrice['Metal']['price']; ?>],
            <?php
                }
            ?>
                        ]];
            $.jqplot('chart-<?php echo $key; ?>',  data, {
                title: '<?php echo $key; ?>',
                highlighter: {
                  show: true,
                  sizeAdjust: 7.5
                },
                cursor: {
                  show: false
                }
            });
        });
    </script>
<?php
    }
}
?>