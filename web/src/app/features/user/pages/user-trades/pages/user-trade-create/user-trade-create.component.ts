import { CommonModule } from '@angular/common';
import { Component, inject } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { UserService } from '../../../../user.service';
import { FormArray, FormBuilder, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { Title } from '@angular/platform-browser';
import { BoardgameService } from '../../../../../boardgame/boardgame.service';

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
  private fb = inject(FormBuilder)
  createTradeForm = this.fb.group({
    title: [''],
    description: [''],
    boardgames: this.fb.array<FormGroup>([])
  });
  tradeId!: number;
  message: any;
  searchResult: any[][] = [];

  
  ngOnInit() {
    this.tradeId = Number(this.route.snapshot.paramMap.get('id'));
    this.loadForm();
  }

  loadForm() {
      this.createTradeForm = this.fb.group ({
        title: [''],
        description: [''],
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
    this.boardgames.removeAt(index);
  }

  submit () {
    this.createTrade()
  }

  goBack() {
    this.router.navigate(['/user/trades'], { replaceUrl: true });
  }

  createTrade () {
    const formValue = this.createTradeForm.value;
    const id = localStorage.getItem('id');
    const payload = {
      user_id: id ? Number(id) : null,
      title: formValue.title!,
      description: formValue.description!,
      boardgames: formValue.boardgames
    }

    this.userService.createTrade(payload).subscribe({
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
