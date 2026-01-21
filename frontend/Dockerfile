FROM node:18-alpine

WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .

# Ekspos port 4135 sesuai instruksi
EXPOSE 4135

CMD ["npm", "run", "dev"]