-- =====================================================
-- Object:  Table [dbo].[cotizaciones]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[cotizaciones] (
    [id] [int] IDENTITY(1,1) NOT NULL,
	[cliente_id] [int] NOT NULL,
	[subtotal] [decimal](10, 2) NOT NULL,
	[iva] [decimal](10, 2) NOT NULL,
	[total] [decimal](10, 2) NOT NULL,
	[fecha_creacion] [datetime] NULL DEFAULT GETDATE(),

    CONSTRAINT FK_Cotizaciones_Clientes FOREIGN KEY (cliente_id)
        REFERENCES [dbo].[clientes] (id)
);