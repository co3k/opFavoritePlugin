<?php

include_page_title(__('Favorite'), __('Member list'));

echo '<center>';
echo pager_total($pager);
echo '</center>';

$list = array();
foreach ($members as $member)
{
  $list[] = link_to($member->getName(), 'member/profile?id=' . $member->getId())
            . '[' . link_to(__('Delete'), 'favorite/delete?id=' . $member->getId()) . ']';
}
$options = array(
  'border' => true,
);
include_list_box('introFriend', $list, $options);

echo pager_navigation($pager, 'favorite/list?page=%d', false);
