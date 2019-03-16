<?php if(count($orders) > 0): /*echo get_option('admin_email'); */ ?>
  <?php foreach($orders as $o): ?>
<table style="margin:4px; border:2px solid black;" cellpadding="4" cellspacing="4">
    <thead>
        <th>Номер заказа</th>
        <th>Имя</th>
        <th>Фамилия</th>
         <th>Адрес</th>
        <th>Телефон</th>
        <th>Email</th>
        <th>Дата выполнения</th>
        <th>Продукт/Дата доставки</th>
    </thead>
    <tbody>
            <tr>
              <td><?php echo $o['id']; ?></td>
              <td><?php echo $o['f_name']; ?></td>
              <td><?php echo $o['l_name']; ?></td>
              <td><?= $o['address'] ?></td>
              <td><?php echo $o['phone']; ?></td>
              <td><?php echo $o['email']; ?></td>
              <td><?= $o['date'] ?></td>
              <td>
                  <?php
                      foreach ($o['productInfo'] as $item) {
                          echo '<b>'.$item['name'].'</b>/'.$item['day'].'<br/><br/>';
                      }
                  ?>
              </td>
            </tr>  
    </tbody>
</table>
<br/>
<?php endforeach; ?>
<?php else: ?>
  <h3 align=center>Нету заказов</h3>
<?php endif; ?>