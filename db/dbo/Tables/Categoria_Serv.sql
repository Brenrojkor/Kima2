-- =====================================================
-- Object:  Table [dbo].[Categoria_Serv]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Categoria_Serv] (
    [ID] [int] IDENTITY(1,1) NOT NULL PRIMARY KEY,
    [Nombre] [nvarchar](255) NOT NULL,
    [FechaCreacion] [datetime] NULL DEFAULT GETDATE()
);