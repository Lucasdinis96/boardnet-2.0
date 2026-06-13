import { PaginationMeta } from "../../../core/models/paginationMeta";
import { BoardgameTrade } from "./boardgameTrade";

export interface BoardgameDetail {
  boardgame: {
    id: number;
    title: string;
    cover: string;
    release: string;
    min_players: number;
    max_players: number;
    age_range: number;
    publisher: string;
    description: string;
  };

  trades: {
    data: BoardgameTrade[];
    meta: PaginationMeta;
  };
}