# Challenge - Backend Engineer

Esta es la solución al challenge de Backend Engineer, que ofrece una manera simple y directa para formar una compañía en los EE.UU. y gestionar la asignación de agentes registrados. La solución se ha desarrollado utilizando **Laravel 12**, **PHP 8.2**, **MySQL** y **Docker**, y cuenta con un front-end en **Angular 19** para interactuar con la API.

## Descripción

La aplicación implementa una API RESTful que permite:
- **Crear una compañía:** Un usuario puede asignarse a sí mismo como agente o utilizar el servicio de agentes.  
- **Listar compañías:** Se obtienen todas las compañías creadas.  
- **Actualizar la asignación de agente:** Permite cambiar el agente asignado para una compañía.  
- **Consultar la capacidad:** Verifica la capacidad disponible de agentes en un estado.

Además, se han implementado eventos y notificaciones:
- **AgentAssigned:** Se dispara cuando se asigna un agente a una nueva compañía.  
- **CapacityThresholdReached:** Se dispara cuando la capacidad asignada en un estado alcanza el 90% o más, notificando al administrador (admin@bizee.test).

## Requisitos

- PHP 8.2 o superior
- Composer
- Docker y Docker Compose
- MySQL (o la base de datos configurada en el entorno)

## Instalación

### Clonar el Repositorio

```bash
git clone https://gitlab.com/victor179/challenge-backend-engineer.git
cd challenge-backend-engineer


composer install

## Configuración del Entorno
cp .env.example .env

#Genera la clave de aplicación
php artisan key:generate

#Levantar el Entorno con Docker
docker-compose up --build -d

#Migrar y Sembrar la Base de Datos
php artisan migrate --seed
