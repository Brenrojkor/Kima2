-- =====================================================
-- Object:  Table [dbo].[Cotizacion]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Cotizacion] (
    [ID] [int] NOT NULL,
	[Cliente_ID] [int] NULL,
	[Descripcion] [varchar](500) NULL,
	[Monto] [decimal](18, 2) NOT NULL,
	[Fecha] [datetime] NULL,
);