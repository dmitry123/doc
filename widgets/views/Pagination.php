<?php
/**
 * @var app\widgets\Pagination $self - Self instance
 * @var int $offset - Start offset
 * @var int $step - Counter accumulator
 */
?>

<nav>
	<?php if (!$self->optimizedMode): ?>
	<ul class="pagination">
		<li <?= $self->getClick($self->currentPage != 1, -1) ?>>
			<a href="javascript:void(0)" aria-label="Предыдущая">
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		<?php if ($self->currentPage > 1): ?>
			<li <?= $self->getClick(true, 1 - $self->currentPage) ?>>
				<a href="javascript:void(0)"><?= 1 ?>
					<span class="sr-only"></span>
				</a>
			</li>
			<?php if ($self->currentPage > 2): ?>
				<li <?= $self->getClick(false, 0) ?>>
					<a href="javascript:void(0)">...
						<span class="sr-only"></span>
					</a>
				</li>
			<?php endif; ?>
		<?php endif; ?>
		<?php for ($i = $self->currentPage + $offset, $j = -1; $i <= $self->totalPages && $j < $self->pageLimit; $i++, $j++): ?>
			<?php if ($i < 1 || $i > $self->totalPages) {
				continue;
			} ?>
			<li <?= $self->getClick(true, $i - $self->currentPage) ?>>
				<a href="javascript:void(0)"><?= $i ?>
					<span class="sr-only"></span>
				</a>
			</li>
		<?php endfor; ?>
		<?php if ($offset == 0): ?>
			<li <?= $self->getClick(false, 0) ?>>
				<a href="javascript:void(0)">...
					<span class="sr-only"></span>
				</a>
			</li>
			<li <?= $self->getClick(true, $self->totalPages - $self->currentPage) ?>>
				<a href="javascript:void(0)"><?= $self->totalPages ?>
					<span class="sr-only"></span>
				</a>
			</li>
		<?php endif; ?>
		<li <?= $self->getClick($self->currentPage != $self->totalPages, 1) ?>>
			<a href="javascript:void(0)" aria-label="Следующая">
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
	</ul>
	<?php else: ?>
	<ul class="pager">
		<li class="previous" <?= $self->getClick($self->currentPage != 1, -1) ?>>
			<a href="javascript:void(0)">
				<span aria-hidden="true">&larr;</span> Предыдущие
			</a>
		</li>
		<li class="next" <?= $self->getClick($self->currentPage != $self->totalPages, 1) ?>>
			<a href="javascript:void(0)">
				Следующие <span aria-hidden="true">&rarr;</span>
			</a>
		</li>
	</ul>
	<?php endif ?>
</nav>