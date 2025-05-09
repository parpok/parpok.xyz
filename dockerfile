FROM node:slim AS runtime
WORKDIR /app

COPY . .

RUN npm install
RUN npm run build

WORKDIR /app/dist

ENV HOST=0.0.0.0
ENV PORT=4321
EXPOSE 4321

CMD ["node", "server/entry.mjs"]