FROM mattrayner/lamp

COPY . /var/www/html
WORKDIR /var/www/html

EXPOSE 80

CMD ["/run.sh"]
