
<div class="row">
    <div class="col-md-5">
        <div class="ibox">
            <div class="ibox-heading">
                <div class="ibox-title">
                    <h5>Programme List</h5>
                </div>
            </div>
            <div class="ibox-content no-padding no-margins panel_height">
                <div style="margin-left: 10px; margin-right: 10px;">
                    <select class="form-control" id="category_type">
                        <?php
                        $vl = $selected;
                        foreach (application_type_search() as $k=>$v){
                            echo '<option '.($vl == $k ? 'selected="selected"':'').' value="'.$k.'"> Category : '.$v.'</option>';
                        }
                        ?>
                    </select>
                </div>
                <table class="table" style="font-size: 14px; width: 100%;"><thead>
                    <tr>
                        <th style="width: 10%;">S/No</th>
                        <th>Programme Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($programme_list as $key=>$value){ ?>
                        <tr>
                            <td><?php echo ($key+1); ?></td>
                            <td><?php echo '<a class="link_clicked" href="'.site_url('programme_setting_selection/'.$value->Code).'" target="iframe2">'.$value->Name.'</a>'; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="col-md-7 no-padding">
        <div class="ibox">
            <div class="ibox-heading">
                <div class="ibox-title">
                    <h5>Selection Criteria Settings</h5>
                </div>
            </div>
            <div class="ibox-content panel_height2" style="padding-right: 0px;">
                <iframe name="iframe2" id="iframe2" style="width: 100%; border: 0px;" onload="resizeIframe(this)" scrolling="yes" border="0" src="<?php echo site_url('programme_setting_selection') ?>" >Your browser does not support this part, Please use latest mozilla, Google Chrome, Opera, Latest Version of Internet Explore</iframe>
            </div>
        </div>
    </div>
</div>



<script>
    $(function () {
        $("#category_type").change(function () {
            var category_type = $(this).val();
            window.location.href = '<?php echo site_url('selection_criteria/') ?>'+category_type;
        }) ;
    });
    function resizeIframe(iframe) {
        iframe.height = iframe.contentWindow.document.body.scrollHeight + "px";
    }
    $(document).ready(function(){

        $(".link_clicked").click(function () {
            $("#iframe2").removeAttr('height');
        });


    });

</script>