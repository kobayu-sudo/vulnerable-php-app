FROM php:8.2-cli

WORKDIR /app

COPY . .

RUN php init-db.php

EXPOSE 10000

CMD ["php", "-S", "0.0.0.0:10000"]
