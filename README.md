# Portfolio Digital Personal – Aron López

## Resumen Ejecutivo
Mi proyecto en el equipo consistió en desarrollar el Sistema de Gestión de Cafetería UPDS, con especial foco en la implementación de la facturación de pedidos y la integración del pago por QR...

## Contribuciones Técnicas
- Tecnologías utilizadas: Blade Templates, Laravel 12, PHP 8.4, MySQL, Git, GitHub, Postman
- Contribuciones clave:
  1. API de facturación (`api/orders/{id}/invoice`)
     - Commit: [link al commit](URL)
     - Permite consultar facturas en JSON
  2. Vista web de factura (`resources/views/orders/invoice.blade.php`)
     - Commit: [link al commit](URL)

## Desafíos Técnicos Resueltos
- Problema: La vista de facturas fallaba...
- Solución: Creé el método orderItems() en el modelo Order...
- Aprendizaje: Comprendí mejor las relaciones hasMany y belongsTo en Laravel
