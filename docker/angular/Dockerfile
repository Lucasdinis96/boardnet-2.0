FROM node:22-alpine

WORKDIR /usr/src/app

COPY package*.json ./

COPY . .

RUN npm install -g @angular/cli

EXPOSE 4200

CMD ["ng", "serve", "--host", "0.0.0.0", "--poll", "2000"]