-- =====================================================
-- Object:  Table [dbo].[TiposProductos]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[TiposProductos] (
    [ID] [int] IDENTITY(1,1) NOT NULL,
    [Nombre] [varchar](100) NOT NULL,
    [Costo] [decimal](10, 2) NOT NULL DEFAULT (0),
    [FechaCreacion] [datetime] NOT NULL DEFAULT GETDATE(),
    [Descripcion] [varchar](255) NULL,
    [id_categoria_serv] [int] NULL,
    
    CONSTRAINT PK_TiposProductos PRIMARY KEY CLUSTERED ([ID] ASC),
    CONSTRAINT UQ_TiposProductos_Nombre UNIQUE NONCLUSTERED ([Nombre] ASC),
    CONSTRAINT FK_TiposProductos_Categoria FOREIGN KEY ([id_categoria_serv]) 
        REFERENCES [dbo].[Categoria_Serv] ([ID])
) 
ON [PRIMARY];