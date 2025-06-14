-- =====================================================
-- Object:  Table [dbo].[detalle_cotizacion]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[detalle_cotizacion] (
    id            INT IDENTITY(1,1) NOT NULL PRIMARY KEY,
    cotizacion_id INT NOT NULL,
    producto_id   INT NOT NULL,
    cantidad      INT NOT NULL,
    precio        DECIMAL(10, 2) NOT NULL,
    subtotal      DECIMAL(10, 2) NOT NULL,

    CONSTRAINT FK_Detalle_Cotizacion_Cotizaciones FOREIGN KEY (cotizacion_id)
        REFERENCES [dbo].[cotizaciones] (id),

    CONSTRAINT FK_Detalle_Cotizacion_Productos FOREIGN KEY (producto_id)
        REFERENCES [dbo].[TiposProductos] (ID)
);