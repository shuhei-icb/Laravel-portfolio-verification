FROM node:22

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    && apt-get clean

CMD ["sh", "-c", "npm install && npm run dev"]
