<script type="text/javascript" src="<?=VIEW?>/js/iColoPicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

    });
</script>

<div style="margin:0" class="row">
    <div class="col-lg-10">
        <h1><?=$title?></h1>
        <div class="col-lg-4">
            <ol class="list-group xd">
                <?foreach($client->get_all() as $value):?>
                    <li>
                        <input style="text-align: center; width: 125px" type="date" value="<?=$value[date]?>" disabled />
                    </li>
                <?endforeach?>
            </ol>
        </div>
    </div>
</div>