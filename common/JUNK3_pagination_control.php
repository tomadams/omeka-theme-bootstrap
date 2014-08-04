<?php if ($this->pageCount > 1): ?>
<div class="pagination">
<ul>
    
    <?php if ($this->first != $this->current): ?>
    <!-- First page link --> 
    <li>
    <a href="<?php echo html_escape($this->url(array('page' => $this->first), null, $_GET)); ?>"><?php echo __('First'); ?></a>
    </li>
    <?php endif; ?>
    
    <?php if (isset($this->previous)): ?>
    <!-- Previous page link --> 
    <li>
    <a href="<?php echo html_escape($this->url(array('page' => $this->previous), null, $_GET)); ?>"><?php echo __('Previous'); ?></a>
    </li>
    <?php endif; ?>
    
    <!-- Numbered page links -->
    <?php foreach ($this->pagesInRange as $page): ?> 
    <?php if ($page != $this->current): ?>
    <li><a href="<?php echo html_escape($this->url(array('page' => $page), null, $_GET)); ?>"><?php echo $page; ?></a></li>
    <?php else: ?>
    <li class="active"><a href="#"><?php echo $page; ?></a></li>
    <?php endif; ?>
    <?php endforeach; ?>
    
    <?php if (isset($this->next)): ?> 
    <!-- Next page link -->
    <li>
    <a href="<?php echo html_escape($this->url(array('page' => $this->next), null, $_GET)); ?>"><?php echo __('Next'); ?></a>
    </li>
    <?php endif; ?>
    
    <?php if ($this->last != $this->current): ?>
    <!-- Last page link --> 
    <li>
    <a href="<?php echo html_escape($this->url(array('page' => $this->last), null, $_GET)); ?>"><?php echo __('Last'); ?></a>
    </li>
    <?php endif; ?>
</ul>
</div>
<?php endif; ?>
