-- =====================================================
-- Object:  Table [dbo].[Tickets]
-- Script Date: 19/4/2025 11:40:26
-- =====================================================

CREATE TABLE [dbo].[Tickets] (
    [ID] [int] IDENTITY(1,1) NOT NULL,
    [TipoProductoID] [int] NOT NULL,
    [ResponsableID] [int] NOT NULL,
    [ClienteID] [int] NOT NULL,
    [EstadoID] [int] NOT NULL,
    [FechaCreacion] [date] NOT NULL,
    [Descripcion] [text] NULL,
    [Documento] [nvarchar](255) NULL,
    [CreadoEn] [datetime] NULL DEFAULT GETDATE(),
    [ActualizadoEn] [datetime] NULL,
    [FechaFin] [datetime] NULL,
    [CategoriaID] [int] NULL,

    CONSTRAINT PK_Tickets PRIMARY KEY CLUSTERED ([ID] ASC),
    CONSTRAINT FK_Tickets_TipoProducto FOREIGN KEY ([TipoProductoID])
        REFERENCES [dbo].[TiposProductos] ([ID]),
    CONSTRAINT FK_Tickets_Responsable FOREIGN KEY ([ResponsableID])
        REFERENCES [dbo].[Usuarios] ([ID]),
    CONSTRAINT FK_Tickets_Cliente FOREIGN KEY ([ClienteID])
        REFERENCES [dbo].[clientes] ([id])
        ON DELETE CASCADE,
    CONSTRAINT FK_Tickets_Estado FOREIGN KEY ([EstadoID])
        REFERENCES [dbo].[EstadosTickets] ([ID]),
    CONSTRAINT FK_Tickets_Categoria FOREIGN KEY ([CategoriaID])
        REFERENCES [dbo].[Categorias] ([ID])
)
ON [PRIMARY] 
TEXTIMAGE_ON [PRIMARY];