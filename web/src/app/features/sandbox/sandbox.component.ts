import { Component, inject, OnInit } from '@angular/core';
import { SandboxService } from './sandbox.service';
import { CommonModule } from '@angular/common';
import { AuthService } from '../../core/services/auth.service';
import { RouterLink } from '@angular/router';


@Component({
  selector: 'app-sandbox',
  imports: [CommonModule, RouterLink],
  templateUrl: './sandbox.component.html',
  styleUrls: ['./sandbox.component.css'],
})
export class SandboxComponent{

  private sandboxService = inject(SandboxService);
  private authService = inject(AuthService);


  testes = this.sandboxService.getTeste();

  testes2 = this.sandboxService.getTeste2(); 

  testeShow = this.sandboxService.getTesteShow();

  
  login () {
    const login = {
      email: "test01@example.com",
      password: "teste01"
    }

    this.authService.login(login).subscribe({next: (res) => {console.log(res.message);}, error: () => {console.error('Erro no login');}});
  }

  logout () {
    this.authService.logout().subscribe({next: (res) => {console.log('Logout')}, error: () =>{this.authService.removeToken()}});
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
