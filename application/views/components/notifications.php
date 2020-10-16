<?php
foreach ($results as $row) {

    $name = 'Admin';

    if ($row->notificationFromType == 'Member') {
        $client = $this->db->query("SELECT * FROM users WHERE userId='" . $row->notificationFrom . "'")->row();
        $name = $client->userFirstName;
    }

?>
    <li>
        <div class="card list-view-media <?php if ($row->notificationStatus == 1) {
                                                echo 'bg-warning';
                                            } ?>" id="nt_<?= $row->notificationID ?>" onclick="notifications_detail(<?= $row->notificationID ?>)">
            <div class="card-block">
                <div class="media">
                    <div class="media-body">
                        <div class="col-xs-12" style="margin-bottom: 5px;">
                            <h5 class="d-inline-block">
                                <?= $name ?></h5>
                        </div>
                        <h6 style="color: #4680ff;"> <?= $row->notificationMessage ?></h6>
                        <p>
                            <?= date("d F Y g:i a", strtotime($row->notificationTime)) ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </li>
<?php } ?>