<style>
table, th, td {
  border:1px solid black;
}
</style>
<table style="width: 50%; border: 1px solid;">
    <tr>
        <th>Name</th>
        <th>Description</th>
    </tr>
    <tbody>
        <?php foreach ($colors as $color): ?>
            <tr>
                <td><?php echo $color->name?></td>
                <td><?php echo $color->description?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>