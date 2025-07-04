-- =====================================================
-- Object:  Table [dbo].[Historial_TiposProductos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Historial_TiposProductos] (
    [ID] [int] IDENTITY(1,1) NOT NULL PRIMARY KEY,
    [TipoProductoID] [int] NOT NULL,
    [Accion] [varchar](20) NOT NULL,
    [NombreAnterior] [nvarchar](255) NULL,
    [CostoAnterior] [decimal](18, 2) NULL,
    [DescripcionAnterior] [nvarchar](max) NULL,
    [CategoriaAnterior] [int] NULL,
    [FechaAccion] [datetime] NULL DEFAULT GETDATE(),
    [Usuario] [nvarchar](100)(100) NULL,
    [Mensaje] [nvarchar](255) NULL,
    [notificaciones_check] [tinyint] NULL DEFAULT 0
);