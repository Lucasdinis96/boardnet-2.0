import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { UserService } from '../../../../services/user.service';
import { FormArray, FormBuilder, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { BoardgameService } from '../../../../../boardgame/boardgame.service';
import { debounceTime } from 'rxjs';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';

@Component({
  selector: 'app-user-trade-create',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-trade-create.component.html',
  styleUrl: './user-trade-create.component.scss',
})
export class UserTradeCreateComponent {

  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private userService = inject(UserService);
  private boardgameService = inject(BoardgameService);
  private flashMessage = inject(FlashMessageService)
  private fb = inject(FormBuilder)
  private readonly MAX_IMAGES = 3;
  createTradeForm = this.fb.group({
    title: [''],
    description: [''],
    shippingFee: [''],
    boardgames: this.fb.array<FormGroup>([])
  });
  tradeId!: number;
  message: any;
  searchResult: any[][] = [];
  selectedImages: File[] = [];
  previewUrls: string[] = [];

  
  ngOnInit() {
    this.tradeId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadForm();
  }

  loadForm() {
      this.createTradeForm = this.fb.group ({
        title: [''],
        description: [''],
        shippingFee: [''],
        boardgames: this.fb.array([
          this.createBoardgameGroup()
        ])
      });

  }

  get boardgames(): FormArray {
    return this.createTradeForm.get('boardgames') as FormArray;
  }

  createBoardgameGroup(): FormGroup {
    return this.fb.group({
      boardgame_id: [''],
      title: [''],
      value: ['']
    });
  }

  addBoardgame() {
    this.boardgames.push(
      this.createBoardgameGroup()
    );
  }

  removeBoardgame(index: number) {
    if (this.boardgames.length === 1 && index === 0) {
      return this.flashMessage.warning('O anúncio deve ter ao menos um jogo registrado.')
    }
    this.boardgames.removeAt(index);
  }

  submit () {
    this.createTrade();
  }

  goBack() {
    this.router.navigate(['/user/trades'], { replaceUrl: true });
  }

  createTrade() {
    const formValue = this.createTradeForm.value;
    const id = localStorage.getItem('id');
    const formData = new FormData();
    formData.append('user_id', id ?? '');
    formData.append('title', formValue.title ?? '' );
    formData.append('description',formValue.description ?? '');
    formData.append('shipping_fee', formValue.shippingFee ?? '');
    formValue.boardgames?.forEach((game: any, index: number) => {
      formData.append(`boardgames[${index}][boardgame_id]`, String(game.boardgame_id));
      formData.append(`boardgames[${index}][value]`, String(game.value ?? 0));
    });
    this.selectedImages.forEach(image => {
      formData.append('images[]',image);
    });
    this.userService.createTrade(formData).subscribe({
      next: (response) => {
        this.flashMessage.success(response.message)
        this.router.navigate(['/user/trades'], { replaceUrl: true }
        );
      },
      error: (response) => {this.flashMessage.error(response.error.message)}
    });
  } 

  searchBoardgames(event: Event, index: number) {
    const value = (event.target as HTMLInputElement).value;

    if (value.length < 2) {
      this.searchResult[index] = [];
    }

    this.boardgameService.searchGame(value).subscribe(results => {
      debounceTime(300),
      this.searchResult[index] = results
    })
  }

  selectBoardgame(boardgame: any, index: number) {
    const group = this.boardgames.at(index);

    group.patchValue({
      boardgame_id: boardgame.id,
      title: boardgame.title
    });

    this.searchResult[index] = [];
  }

  onImagesSelected(event: Event): void {
    
    const input = event.target as HTMLInputElement;

    if (!input.files?.length) {
      return;
    }

    const newFiles = Array.from(input.files);

    if (this.selectedImages.length + newFiles.length > this.MAX_IMAGES) {
      this.flashMessage.warning(`Máximo de ${this.MAX_IMAGES} imagens por anúncio.`);
      input.value = '';
      return;
    }

    this.selectedImages = [
      ...this.selectedImages,
      ...newFiles
    ];

    this.generatePreviews();

    input.value = '';

  }

  generatePreviews(): void {
    this.previewUrls = this.selectedImages.map(file => URL.createObjectURL(file));
  }

  removeImage(index: number): void {
    URL.revokeObjectURL(this.previewUrls[index]);
    this.selectedImages.splice(index, 1);
    this.previewUrls.splice(index, 1);
  }

}
