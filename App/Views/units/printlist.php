<link href="<?= ROOT ?>/public/css/pdf-style.css" type="text/css" rel="stylesheet" />
<page backtop="20mm" backbottom="10mm" backleft="10mm" backright="10mm">
    <?php
    require_once ROOT.'/App/Views/pdf/pdf-header-footer.php';
    ?>

    <h3>Units</h3>

    <table class="pdf-table" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th style="width: 100%">الإسم</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($units as $unit): ?>
            <tr>
                <td><?= $unit->unit ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>





</page>