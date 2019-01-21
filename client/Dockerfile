FROM node:10.15 as builder
RUN apt-get update && npm install -g @angular/cli
WORKDIR /usr/src/app
COPY . /usr/src/app
RUN npm install
RUN ng build --prod

FROM nginx:1.14
COPY --from=builder /usr/src/app/dist/client /usr/share/nginx/html
COPY --from=builder /usr/src/app/container/nginx.conf /etc/nginx/nginx.conf
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
