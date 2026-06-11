import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-pagination',
  standalone: true,
  templateUrl: './pagination.component.html',
  styleUrl: './pagination.component.scss'
})
export class PaginationComponent {

  @Input() currentPage = 1;
  @Input() lastPage = 1;
  @Input() total = 0;

  @Output() pageChange = new EventEmitter<number>();

  previousPage() {
    if (this.currentPage > 1) {
      this.pageChange.emit(this.currentPage - 1);
    }
  }

  nextPage() {
    if (this.currentPage < this.lastPage) {
      this.pageChange.emit(this.currentPage + 1);
    }
  }

  get pages(): number[] {
    return Array.from(
      { length: this.lastPage },
      (_, index) => index + 1
    );
  }
}