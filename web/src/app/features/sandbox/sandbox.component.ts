import { Component, inject, OnInit } from '@angular/core';
import { SandboxService } from './sandbox.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-sandbox',
  imports: [CommonModule],
  templateUrl: './sandbox.component.html',
  styleUrls: ['./sandbox.component.css'],
})
export class SandboxComponent{

  private sandboxService = inject(SandboxService);

  testes = this.sandboxService.getTeste();

  testes2 = this.sandboxService.getTeste2(); 

  testeShow = this.sandboxService.getTesteShow();

  login () {
    const login = {
      email: "test01@example.com",
      password: "teste01"
    }

    this.sandboxService.postTeste(login).subscribe({next: (response) => {console.log('Login realizado', response);}, error: (err) => {console.error('Erro ao criar', err);}});
  }

  updateUser () {
    const login = {
      name: "testePut"
    }

    this.sandboxService.putTeste(login).subscribe({next: (response) => {console.log('Usuario atualizado', response);}, error: (err) => {console.error('Erro ao criar', err);}});
  }

  deleteTrade(){
    this.sandboxService.deleteTeste().subscribe({next: (response) => {console.log('anuncio deletado', response);}, error: (err) => {console.error('Erro ao criar', err);}});
  }







}
