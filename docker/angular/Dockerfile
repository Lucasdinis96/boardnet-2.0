FROM node:22-alpine

WORKDIR /usr/src/app

COPY package*.json ./

COPY . .

EXPOSE 4200

CMD sh -c "npm install && npm run start"