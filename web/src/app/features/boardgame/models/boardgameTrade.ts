export interface BoardgameTrade {
  trade_id: number;
  value: number;

  trade: {
    title: string;
    seller: string;
  };
}