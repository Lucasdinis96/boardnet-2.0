import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { UserService } from '../../../../user.service';
import { FormArray, FormBuilder, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Title } from '@angular/platform-browser';
import { BoardgameService } from '../../../../../boardgame/boardgame.service';

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
  private fb = inject(FormBuilder)
  editTradeForm = this.fb.group({
    title: [''],
    description: [''],
    boardgames: this.fb.array([])
  });
  tradeId!: number;
  message: any;
  searchResult: any[][] = [];

  
  ngOnInit() {
    this.tradeId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadTrade(this.tradeId);
  }

  loadTrade(id: number) {
    this.userService.getTradeById(id).subscribe(trade => {
      this.editTradeForm.patchValue({
        title: trade.title,
        description: trade.description
      });

      this.setBoardgames(trade.boardgames);

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
      value: [boardgame?.value || '']
    });
  }

  addBoardgame() {
    this.boardgames.push(
      this.createBoardgameGroup()
    );
  }

  removeBoardgame(index: number) {
    this.boardgames.removeAt(index);
  }

  submit () {
    this.updateTrade()
  }

  goBack() {
    this.router.navigate(['/user/trades'], { replaceUrl: true });
  }

  updateTrade () {
    const formValue = this.editTradeForm.value;
    const id = Number(this.route.snapshot.paramMap.get('id'));
    const payload = {
      id: id ? Number(id) : null,
      title: formValue.title!,
      description: formValue.description!,
      boardgames: formValue.boardgames
    }

    this.userService.updateTrade(payload, id).subscribe({
      next: (response) => {console.log(response.message)},
      error: () => {console.log('Erro ao atualizar')}
    })
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
      title: boardgame.title
    });

    this.searchResult[index] = [];
  }

}
