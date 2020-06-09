<?php
 foreach($job_intervals as $service)
 { ?>
 <li>
    <div class="card list-view-media" id="tmp_<?=$service->intervalId?>">
        <div class="card-block">
            <div class="media">                
                <div class="media-body">
                    <div class="col-xs-12">
                    <h6 class="d-inline-block">
                        <?=$service->empFirstName.' '.$service->empLastName?></h6>
                        <label class="label label-info">Employe</label>
                    </div>
                    <div class="f-13 text-muted m-b-15">
                            <?=format_datetime($service->createdAt)?>
                    </div>
                    <p><i class="icofont icofont-comment"></i> <?=$service->intervalComments?></p>
                    <p>
                    <i class="icofont icofont-ui-timer"></i> <?=$service->intervalHours?>
                    </p>
                    <p>
                    <?php if($service->intervalStatus!='Complete'){ ?>
                    <i class="icofont icofont-ui-calendar"></i> <b>Next Visit:</b>  
                   <?php                     
                     if($service->nextVisitStatus!='TBD')
                        {
                            echo format_datetime($service->nextVisit);
                        }
                        else
                        {
                            echo 'TBD';
                        }
                    
                   }else { 
                        echo '<label class="label label-success">Job Completed</label>';
                    }
                    ?>                           
                    </p>
                    <p class="text-center">
                    <a href="javascript:;" onclick="view(<?=$service->intervalId?>)" class="btn-out btn-sm waves-effect waves-light btn-primary" ><i class="fa fa-plus-square"></i> View Detail</a>
                    </p>
                </div>
            </div>
        </div>
        </div>
</li>
<?php } ?>
                                                      