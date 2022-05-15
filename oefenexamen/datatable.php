<?php
require_once('config.php');

$sql = "SELECT * FROM enquete";
$result = $conn->query($sql);
$arr_enquetes = [];
if ($result->num_rows > 0) {
    $arr_enquetes = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<table id="enqueteTable">
    <thead>
    <th>Student</th>
    <th>Enquete</th>
    </thead>
    <tbody>
    <?php if(!empty($arr_enquetes)) { ?>
        <?php foreach($arr_enquetes as $enquete) { ?>
            <tr>
                <td><?php echo $enquete['student']; ?></td>
                <td><?php echo '<a href="enquete_detail.php?enquete_id=' . $enquete['enquete_id'] . '">Enquete ' . $enquete['student'] . '</a>' ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
<?php
/**
 * the tutorial that I followed for making this datatable:
 * https://artisansweb.net/how-to-use-datatable-in-php/
 */
?>