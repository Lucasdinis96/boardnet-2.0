import { CommonModule } from '@angular/common';
import { ChangeDetectorRef, Component, inject } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { UserService } from '../../../../services/user.service';
import { FormArray, FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { BoardgameService } from '../../../../../boardgame/boardgame.service';
import { FlashMessageService } from '../../../../../../core/services/flash-message.service';

@Component({
  selector: 'app-user-trade-edit',
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './user-trade-edit.component.html',
  styleUrl: './user-trade-edit.component.scss',
})
export class UserTradeEditComponent {

  private route = inject(ActivatedRoute);
  private router = inject(Router);
  private userService = inject(UserService);
  private boardgameService = inject(BoardgameService);
  private flashMessage = inject(FlashMessageService)
  private fb = inject(FormBuilder)
  private cdr = inject(ChangeDetectorRef)
  private readonly MAX_IMAGES = 3;
  editTradeForm = this.fb.group({
    title: [''],
    description: [''],
    boardgames: this.fb.array([])
  });
  tradeId!: number;
  message: any;
  searchResult: any[][] = [];
  selectedImages: File[] = [];
  existingImages: any[] = [];
  previewUrls: string[] = [];
  primaryImageId: number | null = null;

  
  ngOnInit() {
    this.tradeId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadTrade(this.tradeId);
  }

  loadTrade(id: number) {
    this.userService.getTradeById(id).subscribe(trade => {
      this.setBoardgames(trade.boardgames);
      this.existingImages = trade.images ?? [];
      const primary = this.existingImages.find(
      (image: any) => image.is_primary
      );
      this.primaryImageId = primary?.id ?? null;
      this.editTradeForm.patchValue({
        title: trade.title,
        description: trade.description
      });
      
      this.cdr.detectChanges();
    });
  }

  private setBoardgames(boardgames: any[]) {
    const boardgameFArray = this.boardgames;
    
    boardgameFArray.clear();

    boardgames.forEach(bg => {
      boardgameFArray.push(this.createBoardgameGroup(bg));
    });
  }

  get boardgames(): FormArray {
    return this.editTradeForm.get('boardgames') as FormArray;
  }

  createBoardgameGroup(boardgame?: any): FormGroup {
    return this.fb.group({
      boardgame_id: [boardgame?.id || ''],
      title: [boardgame?.title || ''],
      value: [boardgame?.trade_item.value || 0]
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
    this.updateTrade();
  }

  goBack() {
    this.router.navigate(['/user/trades'], { replaceUrl: true });
  }

  updateTrade() {
    const formValue = this.editTradeForm.value;
    const formData = new FormData();
    const id = Number(this.route.snapshot.paramMap.get('id'));
    formData.append('title', formValue.title ?? '');
    formData.append('description', formValue.description ?? '');
    formValue.boardgames?.forEach((boardgame: any, index: number) => {
      formData.append(`boardgames[${index}][boardgame_id]`, boardgame.boardgame_id);
      formData.append(`boardgames[${index}][value]`,boardgame.value ?? '');
    });
    this.existingImages.forEach((image, index) => {
      formData.append(`remaining_images[${index}]`, image.id);
    });
    this.selectedImages.forEach(image => {
      formData.append('images[]', image);
    });
    if (this.primaryImageId) {
      formData.append('primary_image_id', String(this.primaryImageId));
    }
    this.userService.updateTrade(formData, id).subscribe({
        next: (response) => {
          this.flashMessage.success(response.message)
          this.router.navigate(['/user/trades'], { replaceUrl: true }
          );
        },
        error: (error) => {this.flashMessage.error(error.message);}
      });
  }

  searchBoardgames(event: Event, index: number) {
    const value = (event.target as HTMLInputElement).value;

    if (value.length < 2) {
      this.searchResult[index] = [];
    }

    this.boardgameService.searchGame(value).subscribe(results => {
      this.searchResult[index] = results
    })
  }

  selectBoardgame(boardgame: any, index: number) {
    const group = this.boardgames.at(index);

    group.patchValue({
      boardgame_id: boardgame.id,
      title: boardgame.title,
    });

    this.searchResult[index] = [];
  }

  onImagesSelected(event: Event): void {
    const input = event.target as HTMLInputElement;
    if (!input.files?.length) {
      return;
    }
    const newFiles = Array.from(input.files);
    if (this.selectedImages.length + newFiles.length > this.MAX_IMAGES || this.existingImages.length+newFiles.length > this.MAX_IMAGES) {
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

  removeExistingImage(index: number): void {
    this.existingImages.splice(index, 1);
  }

  getImageUrl(path: string): string {
    return `http://api.localhost:8080/storage/${path}`;
  }

  setPrimaryImage(imageId: number): void {
    this.primaryImageId = imageId;
  }
}



